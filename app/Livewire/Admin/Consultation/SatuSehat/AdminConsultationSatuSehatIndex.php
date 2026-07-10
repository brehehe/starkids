<?php

namespace App\Livewire\Admin\Consultation\SatuSehat;

use App\Helpers\AlertHelper;
use App\Models\Api\ApiOutboxTask;
use App\Models\Encounter\Encounter;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
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

    public string $tab = 'patient'; // patient, encounter, outbox

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
        if (in_array($tab, ['patient', 'encounter', 'outbox'])) {
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
            ->take(100) // limit to avoid memory/time limit
            ->get();

        if ($unsyncedUsers->isEmpty()) {
            AlertHelper::info('Info', 'Semua pasien sudah tersinkronisasi.');

            return;
        }

        $queued = 0;
        foreach ($unsyncedUsers as $user) {
            $patient = Patient::where('user_id', $user->id)->first();
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

    public function queueEncounter(string $encounterId): void
    {
        $encounter = Encounter::with('transaction')->find($encounterId);
        if (! $encounter || ! $encounter->transaction) {
            AlertHelper::error('Gagal', 'Data kunjungan/transaksi tidak ditemukan.');

            return;
        }

        $transaction = $encounter->transaction;
        $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
        $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

        if (! $patient) {
            AlertHelper::info('Dilewati', "Kunjungan transaksi {$transaction->code} dilewati karena data pasien tidak ditemukan.");

            return;
        }

        $data = [
            'pending' => true,
            'id' => $encounter->id,
            'transaction_id' => $transaction->id,
            'company_id' => $transaction->company_id,
            'location_id' => $transaction->location_id,
            'patient_id' => $patient->id,
            'practitioner_id' => $doctor->id ?? null,
            'type' => 'outpatient',
            'status' => 'planned',
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
        $unsyncedEncounters = Encounter::whereHas('transaction', function ($query) {
            $query->where('company_id', auth()->user()->company_id);
        })
            ->whereHas('transaction.patient.patient.OHPatient', function ($query) {
                $query->whereNotNull('id_patient');
            })
            ->where(function ($query) {
                $query->whereDoesntHave('OHEncounter')
                    ->orWhereHas('OHEncounter', function ($sq) {
                        $sq->whereNull('id_encounter');
                    });
            })
            ->with('transaction')
            ->take(100)
            ->get();

        if ($unsyncedEncounters->isEmpty()) {
            AlertHelper::info('Info', 'Semua kunjungan sudah tersinkronisasi.');

            return;
        }

        $queued = 0;
        foreach ($unsyncedEncounters as $encounter) {
            $transaction = $encounter->transaction;
            if (! $transaction) {
                continue;
            }
            $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
            $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

            $data = [
                'pending' => true,
                'id' => $encounter->id,
                'transaction_id' => $transaction->id,
                'company_id' => $transaction->company_id,
                'location_id' => $transaction->location_id,
                'patient_id' => $patient->id ?? null,
                'practitioner_id' => $doctor->id ?? null,
                'type' => 'outpatient',
                'status' => 'planned',
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
        $encounters = Encounter::whereHas('transaction', function ($query) {
            $query->where('company_id', auth()->user()->company_id);
        })
            ->whereHas('transaction.patient.patient.OHPatient', function ($query) {
                $query->whereNotNull('id_patient');
            })
            ->with('transaction')
            ->take(100)
            ->get();

        if ($encounters->isEmpty()) {
            AlertHelper::info('Info', 'Tidak ada kunjungan yang dapat disinkronkan.');

            return;
        }

        $queued = 0;
        foreach ($encounters as $encounter) {
            $transaction = $encounter->transaction;
            if (! $transaction) {
                continue;
            }
            $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
            $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

            $data = [
                'pending' => true,
                'id' => $encounter->id,
                'transaction_id' => $transaction->id,
                'company_id' => $transaction->company_id,
                'location_id' => $transaction->location_id,
                'patient_id' => $patient->id ?? null,
                'practitioner_id' => $doctor->id ?? null,
                'type' => 'outpatient',
                'status' => 'planned',
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
            ->update([
                'status' => 'pending',
                'execution' => 0,
            ]);

        AlertHelper::success('Berhasil', "Berhasil menyetel ulang {$updated} antrian gagal kembali ke antrian aktif.");
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
        $stats = [
            'pending' => ApiOutboxTask::where('status', 'pending')->count(),
            'process' => ApiOutboxTask::where('status', 'process')->count(),
            'success' => ApiOutboxTask::where('status', 'success')->count(),
            'failed' => ApiOutboxTask::where('status', 'failed')->count(),
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

            if (! empty($ohPatientIds)) {
                $tasks = ApiOutboxTask::where(function ($query) use ($ohPatientIds) {
                    foreach ($ohPatientIds as $id) {
                        $query->orWhere('model_ids', 'like', '%"'.$id.'"%');
                    }
                })
                    ->where('model_classes', 'like', '%OneHealthPatient%')
                    ->orderBy('created_at', 'asc')
                    ->get();

                foreach ($tasks as $task) {
                    foreach ($task->model_ids as $id) {
                        if (in_array($id, $ohPatientIds)) {
                            $outboxStatuses[$id] = $task;
                        }
                    }
                }
            }
        } elseif ($this->tab === 'encounter') {
            $dataList = Encounter::whereHas('transaction', function ($query) {
                $query->where('company_id', auth()->user()->company_id);
            })

                ->when($this->search, function ($query) {
                    $query->whereHas('transaction', function ($q) {
                        $q->where('code', 'ilike', '%'.$this->search.'%')
                            ->orWhere('patient_name', 'ilike', '%'.$this->search.'%');
                    });
                })
                ->with(['transaction.patient.patient.OHPatient', 'transaction.doctor', 'OHEncounter'])
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);

            $ohEncounterIds = collect($dataList->items())
                ->map(fn ($encounter) => $encounter->OHEncounter?->id)
                ->filter()
                ->toArray();

            if (! empty($ohEncounterIds)) {
                $tasks = ApiOutboxTask::where(function ($query) use ($ohEncounterIds) {
                    foreach ($ohEncounterIds as $id) {
                        $query->orWhere('model_ids', 'like', '%"'.$id.'"%');
                    }
                })
                    ->where('model_classes', 'like', '%OneHealthEncounter%')
                    ->orderBy('created_at', 'asc')
                    ->get();

                foreach ($tasks as $task) {
                    foreach ($task->model_ids as $id) {
                        if (in_array($id, $ohEncounterIds)) {
                            $outboxStatuses[$id] = $task;
                        }
                    }
                }
            }
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
