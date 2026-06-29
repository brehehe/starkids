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

    protected array $queryString = [
        'search' => ['except' => ''],
        'tab' => ['except' => 'patient'],
        'outboxStatus' => ['except' => ''],
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

    public function retryFailedTasks(): void
    {
        $updated = ApiOutboxTask::where('status', 'failed')
            ->update([
                'status' => 'pending',
                'execution' => 0,
            ]);

        AlertHelper::success('Berhasil', "Berhasil menyetel ulang {$updated} antrian gagal kembali ke antrian aktif.");
    }

    public function clearFailedTasks(): void
    {
        $deleted = ApiOutboxTask::where('status', 'failed')->delete();

        AlertHelper::success('Berhasil', "Berhasil membersihkan {$deleted} antrian yang gagal.");
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
                ->with(['patient.OHPatient', 'userDetail'])
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);
        } elseif ($this->tab === 'encounter') {
            $dataList = Encounter::whereHas('transaction', function ($query) {
                $query->where('company_id', auth()->user()->company_id);
            })
                ->where(function ($query) {
                    $query->whereDoesntHave('OHEncounter')
                        ->orWhereHas('OHEncounter', function ($sq) {
                            $sq->whereNull('id_encounter');
                        });
                })
                ->when($this->search, function ($query) {
                    $query->whereHas('transaction', function ($q) {
                        $q->where('code', 'ilike', '%'.$this->search.'%')
                            ->orWhere('patient_name', 'ilike', '%'.$this->search.'%');
                    });
                })
                ->with(['transaction.patient', 'transaction.doctor', 'OHEncounter'])
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);
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
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
