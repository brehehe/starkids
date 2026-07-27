<?php

namespace App\Livewire\Admin\Consultation\SatuSehat;

use App\Helpers\AlertHelper;
use App\Models\Api\ApiOutboxTask;
use App\Models\Encounter\Encounter;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\service\apiservice;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AdminConsultationSatuSehatIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public int $perPage = 10;

    public string $tab = 'patient'; // patient, synced_patient, encounter, synced_encounter, outbox

    public string $outboxStatus = ''; // filter for outbox status

    public string $nikFilter = ''; // filter for NIK presence: 'yes', 'no', or empty

    public ?string $editingTaskId = null;

    public string $editingRequestBody = '';

    public string $editingTaskError = '';

    public string $editingTaskStatus = '';

    public bool $showEditModal = false;

    protected array $queryString = [
        'search' => ['except' => ''],
        'tab' => ['except' => 'patient'],
        'outboxStatus' => ['except' => ''],
        'nikFilter' => ['except' => ''],
    ];

    public function mount(): void
    {
        //
    }

    public function changeTab(string $tab): void
    {
        if (in_array($tab, ['patient', 'synced_patient', 'encounter', 'synced_encounter', 'outbox'])) {
            $this->tab = $tab;
            $this->resetPage();
            $this->search = '';
        }
    }

    // public function hydrate(): void
    // {
    //     $this->resetPage();
    // }

    public function queuePatient(string $userId): void
    {
        $user = User::with('userDetail')->find($userId);
        if (! $user) {
            AlertHelper::error('Gagal', 'Data user tidak ditemukan.');

            return;
        }

        $patient = Patient::where('user_id', $user->id)->first();
        $identityCardMother = $patient ? $patient->identity_card_mother : false;

        try {
            app(apiservice::class)->createUser($user, $identityCardMother);
            AlertHelper::success('Berhasil', "Pasien {$user->name} telah ditambahkan ke antrian sinkronisasi.");
        } catch (\Exception $e) {
            AlertHelper::error('Gagal', "Gagal menambahkan pasien ke antrian: {$e->getMessage()}");
        }
    }

    public function queueAllUnsyncedPatients(): void
    {
        $unsyncedUsers = User::query()
            ->companyRole('Pasien', auth()->user()->company_id)
            ->where(function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->whereDoesntHave('OHPatient')
                        ->orWhereHas('OHPatient', function ($sq) {
                            $sq->whereNull('id_patient');
                        });
                })->orWhereDoesntHave('patient');
            })
            ->with(['patient', 'userDetail'])
            ->take(100)
            ->get();

        if ($unsyncedUsers->isEmpty()) {
            AlertHelper::info('Info', 'Semua pasien sudah tersinkronisasi.');

            return;
        }

        $queued = 0;
        foreach ($unsyncedUsers as $user) {
            $patient = $user->patient;
            $identityCardMother = $patient ? $patient->identity_card_mother : false;
            try {
                app(apiservice::class)->createUser($user, $identityCardMother);
                $queued++;
            } catch (\Exception $e) {
                // ignore and continue
            }
        }

        AlertHelper::success('Berhasil', "Berhasil menambahkan {$queued} pasien ke antrian sinkronisasi.");
    }

    protected function getOutboxModelIds(ApiOutboxTask $task): array
    {
        $ids = $task->model_ids;
        if (is_string($ids)) {
            $decoded = json_decode($ids, true);
            $ids = is_array($decoded) ? $decoded : [$ids];
        }

        return is_array($ids) ? $ids : [];
    }

    protected function fetchOutboxStatuses(array $modelIds, string $modelClassKeyword): array
    {
        if (empty($modelIds)) {
            return [];
        }

        $outboxStatuses = [];
        $tasks = ApiOutboxTask::query()
            ->select(['id', 'model_ids', 'model_classes', 'status', 'response_body'])
            ->where(function ($query) use ($modelIds) {
                foreach ($modelIds as $id) {
                    $query->orWhereRaw('model_ids::text ILIKE ?', ['%'.$id.'%']);
                }
            })
            ->whereRaw('model_classes::text ILIKE ?', ['%'.$modelClassKeyword.'%'])
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($tasks as $task) {
            foreach ($this->getOutboxModelIds($task) as $id) {
                if (in_array($id, $modelIds)) {
                    $outboxStatuses[$id] = $task;
                }
            }
        }

        return $outboxStatuses;
    }

    protected function getEncounterStatus(Transaction $transaction, ?Encounter $encounter = null): string
    {
        if ($encounter && ! empty($encounter->status) && ! in_array($encounter->status, ['unknown', 'planned'])) {
            return $encounter->status;
        }

        $trxStatus = strtolower($transaction->status ?? '');

        return match ($trxStatus) {
            'completed', 'finished', 'done', 'pharmacy', 'paid', 'success' => 'finished',
            'consultation', 'in_progress', 'process', 'in-progress' => 'in-progress',
            'arrived', 'draft_consultation', 'waiting' => 'arrived',
            'canceled', 'cancelled' => 'cancelled',
            default => $encounter->status ?? 'planned',
        };
    }

    public function queueEncounter(string $id): void
    {
        $encounter = Encounter::with('transaction')->find($id);
        if ($encounter) {
            $transaction = $encounter->transaction;
        } else {
            $transaction = Transaction::find($id);
            $encounter = Encounter::where('transaction_id', $id)->first();
        }

        if (! $transaction) {
            AlertHelper::error('Gagal', 'Data kunjungan/transaksi tidak ditemukan.');

            return;
        }

        $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
        $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

        if (! $patient) {
            AlertHelper::info('Dilewati', "Kunjungan transaksi {$transaction->code} dilewati karena data pasien tidak ditemukan.");

            return;
        }

        if (! $doctor) {
            AlertHelper::info('Dilewati', "Kunjungan transaksi {$transaction->code} dilewati karena data praktisi (dokter) belum terdaftar di master praktisi.");

            return;
        }

        $data = [
            'pending' => true,
            'id' => $encounter?->id ?? null,
            'transaction_id' => $transaction->id,
            'company_id' => $transaction->company_id,
            'location_id' => $transaction->location_id,
            'patient_id' => $patient->id,
            'practitioner_id' => $doctor->id,
            'type' => 'outpatient',
            'status' => $this->getEncounterStatus($transaction, $encounter),
            'class_code' => 'AMB',
        ];

        try {
            app(apiservice::class)->createTransaction($data);
            AlertHelper::success('Berhasil', "Kunjungan transaksi {$transaction->code} telah ditambahkan ke antrian sinkronisasi.");
        } catch (\Exception $e) {
            AlertHelper::error('Gagal', "Gagal menambahkan kunjungan ke antrian: {$e->getMessage()}");
        }
    }

    public function queueAllUnsyncedEncounters(): void
    {
        $unsyncedTransactions = Transaction::where('company_id', auth()->user()->company_id)
            ->whereHas('patient.patient.OHPatient', function ($query) {
                $query->whereNotNull('id_patient');
            })
            ->where(function ($query) {
                $query->whereDoesntHave('encounter')
                    ->orWhereHas('encounter', function ($eq) {
                        $eq->whereDoesntHave('OHEncounter')
                            ->orWhereHas('OHEncounter', function ($sq) {
                                $sq->whereNull('id_encounter');
                            });
                    });
            })
            ->with(['encounter', 'patient.patient'])
            ->take(100)
            ->get();

        if ($unsyncedTransactions->isEmpty()) {
            AlertHelper::info('Info', 'Semua kunjungan transaksi sudah tersinkronisasi.');

            return;
        }

        $patientUserIds = $unsyncedTransactions->pluck('patient_id')->filter()->unique();
        $doctorUserIds = $unsyncedTransactions->pluck('doctor_id')->filter()->unique();

        $patientsMap = Patient::whereIn('user_id', $patientUserIds)->pluck('id', 'user_id');
        $doctorsMap = Practitioner::whereIn('user_id', $doctorUserIds)->pluck('id', 'user_id');

        $queued = 0;
        foreach ($unsyncedTransactions as $transaction) {
            $patientId = $patientsMap[$transaction->patient_id] ?? null;
            $doctorId = $doctorsMap[$transaction->doctor_id] ?? null;

            if (! $patientId || ! $doctorId) {
                continue;
            }

            $data = [
                'pending' => true,
                'id' => $transaction->encounter?->id ?? null,
                'transaction_id' => $transaction->id,
                'company_id' => $transaction->company_id,
                'location_id' => $transaction->location_id,
                'patient_id' => $patientId,
                'practitioner_id' => $doctorId,
                'type' => 'outpatient',
                'status' => $this->getEncounterStatus($transaction, $transaction->encounter),
                'class_code' => 'AMB',
            ];

            try {
                app(apiservice::class)->createTransaction($data);
                $queued++;
            } catch (\Exception $e) {
                // ignore
            }
        }

        AlertHelper::success('Berhasil', "Berhasil menambahkan {$queued} kunjungan ke antrian sinkronisasi.");
    }

    public function queueAllSyncableEncounters(): void
    {
        $transactions = Transaction::where('company_id', auth()->user()->company_id)
            ->whereHas('patient.patient.OHPatient', function ($query) {
                $query->whereNotNull('id_patient');
            })
            ->with(['encounter', 'patient.patient'])
            ->take(100)
            ->get();

        if ($transactions->isEmpty()) {
            AlertHelper::info('Info', 'Tidak ada kunjungan transaksi yang dapat disinkronkan.');

            return;
        }

        $patientUserIds = $transactions->pluck('patient_id')->filter()->unique();
        $doctorUserIds = $transactions->pluck('doctor_id')->filter()->unique();

        $patientsMap = Patient::whereIn('user_id', $patientUserIds)->pluck('id', 'user_id');
        $doctorsMap = Practitioner::whereIn('user_id', $doctorUserIds)->pluck('id', 'user_id');

        $queued = 0;
        foreach ($transactions as $transaction) {
            $patientId = $patientsMap[$transaction->patient_id] ?? null;
            $doctorId = $doctorsMap[$transaction->doctor_id] ?? null;

            if (! $patientId || ! $doctorId) {
                continue;
            }

            $data = [
                'pending' => true,
                'id' => $transaction->encounter?->id ?? null,
                'transaction_id' => $transaction->id,
                'company_id' => $transaction->company_id,
                'location_id' => $transaction->location_id,
                'patient_id' => $patientId,
                'practitioner_id' => $doctorId,
                'type' => 'outpatient',
                'status' => $this->getEncounterStatus($transaction, $transaction->encounter),
                'class_code' => 'AMB',
            ];

            try {
                app(apiservice::class)->createTransaction($data);
                $queued++;
            } catch (\Exception $e) {
                // ignore
            }
        }

        AlertHelper::success('Berhasil', "Berhasil menambahkan {$queued} kunjungan ke antrian sinkronisasi ulang.");
    }

    public function retryFailedTasks(): void
    {
        $updated = ApiOutboxTask::where('status', 'failed')
            ->orWhere('execution', '>', 3)
            ->update([
                'status' => 'pending',
                'execution' => 0,
            ]);

        AlertHelper::success('Berhasil', "Berhasil menyetel ulang {$updated} antrian kembali ke antrian aktif.");
    }

    public function retryTask(string $taskId): void
    {
        $task = ApiOutboxTask::find($taskId);
        if ($task) {
            $task->update([
                'status' => 'pending',
                'execution' => 0,
            ]);
            AlertHelper::success('Berhasil', 'Antrian berhasil disetel ulang ke status pending.');
        }
    }

    public function deleteTask(string $taskId): void
    {
        $task = ApiOutboxTask::find($taskId);
        if ($task) {
            $task->delete();
            AlertHelper::success('Berhasil', 'Antrian berhasil dihapus.');
        }
    }

    public function clearSuccessTasks(): void
    {
        $deleted = ApiOutboxTask::where('status', 'success')->delete();

        AlertHelper::success('Berhasil', "Berhasil membersihkan {$deleted} antrian yang sukses.");
    }

    public function clearFailedTasks(): void
    {
        $deleted = ApiOutboxTask::where('status', 'failed')->delete();

        AlertHelper::success('Berhasil', "Berhasil membersihkan {$deleted} antrian yang gagal.");
    }

    public function clearAllTasks(): void
    {
        $deleted = ApiOutboxTask::query()->delete();

        AlertHelper::success('Berhasil', "Berhasil membersihkan seluruh {$deleted} antrian outbox.");
    }

    public function editTask(string $taskId): void
    {
        $task = ApiOutboxTask::find($taskId);
        if ($task) {
            $this->editingTaskId = $task->id;
            $decoded = json_decode($task->request_body, true);
            $this->editingRequestBody = $decoded ? json_encode($decoded, JSON_PRETTY_PRINT) : $task->request_body;
            $this->editingTaskError = $task->response_body ?? '';
            $this->editingTaskStatus = $task->status;
            $this->showEditModal = true;
        }
    }

    public function saveTaskPayload(): void
    {
        if (! $this->editingTaskId) {
            return;
        }

        $task = ApiOutboxTask::find($this->editingTaskId);
        if ($task) {
            $decoded = json_decode($this->editingRequestBody, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                AlertHelper::error('Gagal', 'Format JSON tidak valid.');

                return;
            }

            $task->update([
                'request_body' => json_encode($decoded),
                'status' => 'pending',
                'execution' => 0,
            ]);

            AlertHelper::success('Berhasil', 'Payload berhasil diperbarui dan dimasukkan kembali ke antrian.');
            $this->closeEditModal();
        }
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->editingTaskId = null;
        $this->editingRequestBody = '';
        $this->editingTaskError = '';
        $this->editingTaskStatus = '';
    }

    public function formatResponseBody(?string $responseBody): string
    {
        if (empty($responseBody)) {
            return '-';
        }

        $decoded = json_decode($responseBody, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $responseBody;
        }

        // Jika response dibungkus Exception logbox {"message": "...", "file": "...", "line": ...}
        if (isset($decoded['message'])) {
            $innerMessage = $decoded['message'];
            $innerDecoded = json_decode($innerMessage, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $decoded = $innerDecoded;
            } else {
                return $innerMessage;
            }
        }

        // Jika merupakan OperationOutcome dari SatuSehat
        if (isset($decoded['resourceType']) && $decoded['resourceType'] === 'OperationOutcome') {
            $issues = [];
            foreach ($decoded['issue'] ?? [] as $issue) {
                $details = $issue['details']['text'] ?? '';
                $expression = isset($issue['expression']) ? ' ('.implode(', ', $issue['expression']).')' : '';
                if ($details) {
                    $issues[] = $details.$expression;
                }
            }
            if (! empty($issues)) {
                return implode('; ', $issues);
            }
        }

        // Jika JSON biasa, pretty-print dengan rapi
        return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function render(): View
    {
        $statsRaw = ApiOutboxTask::query()
            ->selectRaw("
                COUNT(*) FILTER (WHERE status = 'pending') as pending,
                COUNT(*) FILTER (WHERE status = 'process') as process,
                COUNT(*) FILTER (WHERE status = 'success') as success,
                COUNT(*) FILTER (WHERE status = 'failed') as failed
            ")
            ->first();

        $stats = [
            'pending' => (int) ($statsRaw->pending ?? 0),
            'process' => (int) ($statsRaw->process ?? 0),
            'success' => (int) ($statsRaw->success ?? 0),
            'failed' => (int) ($statsRaw->failed ?? 0),
        ];

        $dataList = [];
        $outboxStatuses = [];

        if ($this->tab === 'patient') {
            $dataList = User::query()
                ->companyRole('Pasien', auth()->user()->company_id)
                ->where(function ($query) {
                    $query->whereHas('patient', function ($q) {
                        $q->whereDoesntHave('OHPatient')
                            ->orWhereHas('OHPatient', function ($sq) {
                                $sq->whereNull('id_patient');
                            });
                    })->orWhereDoesntHave('patient');
                })
                ->when($this->search, function ($query) {
                    $query->where('name', 'ilike', '%'.$this->search.'%')
                        ->orWhereHas('userDetail', function ($q) {
                            $q->where('identity_card', 'ilike', '%'.$this->search.'%');
                        });
                })
                ->when($this->nikFilter, function ($query) {
                    if ($this->nikFilter === 'yes') {
                        $query->whereHas('userDetail', function ($q) {
                            $q->whereNotNull('identity_card')->where('identity_card', '!=', '');
                        });
                    } elseif ($this->nikFilter === 'no') {
                        $query->where(function ($q) {
                            $q->whereDoesntHave('userDetail')
                                ->orWhereHas('userDetail', function ($sq) {
                                    $sq->whereNull('identity_card')->orWhere('identity_card', '');
                                });
                        });
                    }
                })
                ->with(['patient.OHPatient', 'userDetail'])
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);

            $ohPatientIds = collect($dataList->items())
                ->map(fn ($user) => $user->patient?->OHPatient?->id)
                ->filter()
                ->toArray();

            $outboxStatuses = $this->fetchOutboxStatuses($ohPatientIds, 'OneHealthPatient');
        } elseif ($this->tab === 'synced_patient') {
            $dataList = User::query()
                ->companyRole('Pasien', auth()->user()->company_id)
                ->whereHas('patient', function ($q) {
                    $q->whereHas('OHPatient', function ($sq) {
                        $sq->whereNotNull('id_patient');
                    });
                })
                ->when($this->search, function ($query) {
                    $query->where('name', 'ilike', '%'.$this->search.'%')
                        ->orWhereHas('userDetail', function ($q) {
                            $q->where('identity_card', 'ilike', '%'.$this->search.'%');
                        })
                        ->orWhereHas('patient.OHPatient', function ($q) {
                            $q->where('id_patient', 'ilike', '%'.$this->search.'%');
                        });
                })
                ->with(['patient.OHPatient', 'userDetail'])
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);

            $ohPatientIds = collect($dataList->items())
                ->map(fn ($user) => $user->patient?->OHPatient?->id)
                ->filter()
                ->toArray();

            $outboxStatuses = $this->fetchOutboxStatuses($ohPatientIds, 'OneHealthPatient');
        } elseif ($this->tab === 'encounter') {
            $dataList = Transaction::query()
                ->where('company_id', auth()->user()->company_id)
                ->whereHas('patient.patient.OHPatient', function ($query) {
                    $query->whereNotNull('id_patient');
                })
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('code', 'ilike', '%'.$this->search.'%')
                            ->orWhere('patient_name', 'ilike', '%'.$this->search.'%')
                            ->orWhere('doctor_name', 'ilike', '%'.$this->search.'%');
                    });
                })
                ->with([
                    'patient.patient.OHPatient',
                    'encounter.OHEncounter',
                ])
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);

            $ohEncounterIds = collect($dataList->items())
                ->map(fn ($trx) => $trx->encounter?->OHEncounter?->id)
                ->filter()
                ->toArray();

            $outboxStatuses = $this->fetchOutboxStatuses($ohEncounterIds, 'OneHealthEncounter');
        } elseif ($this->tab === 'synced_encounter') {
            $dataList = Encounter::whereHas('transaction', function ($query) {
                $query->where('company_id', auth()->user()->company_id);
            })
                ->whereHas('transaction.patient.patient.OHPatient', function ($query) {
                    $query->whereNotNull('id_patient');
                })
                ->when($this->search, function ($query) {
                    $query->whereHas('transaction', function ($q) {
                        $q->where('code', 'ilike', '%'.$this->search.'%')
                            ->orWhere('patient_name', 'ilike', '%'.$this->search.'%')
                            ->orWhere('doctor_name', 'ilike', '%'.$this->search.'%');
                    })->orWhereHas('OHEncounter', function ($q) {
                        $q->where('id_encounter', 'ilike', '%'.$this->search.'%');
                    });
                })
                ->with(['transaction.patient.patient.OHPatient', 'transaction.doctor', 'OHEncounter'])
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);

            $ohEncounterIds = collect($dataList->items())
                ->map(fn ($encounter) => $encounter->OHEncounter?->id)
                ->filter()
                ->toArray();

            $outboxStatuses = $this->fetchOutboxStatuses($ohEncounterIds, 'OneHealthEncounter');
        } elseif ($this->tab === 'outbox') {
            $dataList = ApiOutboxTask::query()
                ->when($this->outboxStatus, function ($query) {
                    $query->where('status', $this->outboxStatus);
                })
                ->when($this->search, function ($query) {
                    $query->where('service_method', 'ilike', '%'.$this->search.'%')
                        ->orWhere('request_body', 'ilike', '%'.$this->search.'%')
                        ->orWhere('response_body', 'ilike', '%'.$this->search.'%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);
        }

        return view('livewire.admin.consultation.satusehat.admin-consultation-satusehat-index', [
            'dataList' => $dataList,
            'stats' => $stats,
            'outboxStatuses' => $outboxStatuses,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
