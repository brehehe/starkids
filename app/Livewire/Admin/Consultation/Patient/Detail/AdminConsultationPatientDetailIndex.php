<?php

namespace App\Livewire\Admin\Consultation\Patient\Detail;

use App\Helpers\AlertHelper;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionDiagnosis;
use App\Models\Transaction\TransactionIcd10;
use App\Models\Transaction\TransactionIcd9;
use App\Models\Transaction\TransactionPayment;
use App\Models\Transaction\TransactionPhysicalExamination;
use App\Models\Transaction\TransactionProduct;
use App\Models\Transaction\TransactionProofOfAction;
use App\Models\Transaction\TransactionRecipe;
use App\Models\Transaction\TransactionReference;
use App\Models\User;
use App\Models\User\AllergyMedicine;
use App\Models\User\UserControlSchedule;
use Livewire\Component;
use Livewire\WithPagination;
use Session;
use Illuminate\Support\Str;

class AdminConsultationPatientDetailIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $search = '';
    public $perPage = 5;
    public $user_id;
    public $user;

    public $get_tabs = ['konsultasi','diagnosa', 'alergi', 'icd-10', 'icd-9', 'tindakan', 'bukti-tindakan','odontogram', 'resep', 'jadwal-kontrol', 'rujukan', 'penjualan', 'terima-bayar', 'laba-rugi', 'observasi'];

    public $tab;
    public $transactions = [];
    public $odontogram_map = [];
    public $frequent_odontogram = null;
    public $odontogram = null; // Needed for blade compatibility if we share code
    public $odontogram_color = '#3b82f6'; // Default color

    public function mount($id = null)
    {
        $this->user_id = $id ?? Session::get('patient_id');
        if (!$this->user_id) {
            return redirect()->route('user.consultation.patient');
        }

        // cek valid UUID
        if (!Str::isUuid($this->user_id)) {
            AlertHelper::error('Gagal', 'ID pasien tidak valid.');
            return redirect()->route('user.consultation.patient');
        }

        $this->user = User::find($this->user_id);
        if (!$this->user) {
            AlertHelper::error('Gagal', 'Data pasien tidak ditemukan.');
            return redirect()->route('user.consultation.patient');
        }

        $this->transactions = Transaction::where('patient_id', $this->user_id)
            ->where('company_id', auth()->user()->company_id)
            ->pluck('id')
            ->toArray();

        $this->changeTab('konsultasi');
    }

    public function changeTab($tab)
    {
        if (!in_array($tab, $this->get_tabs)) {
            AlertHelper::error('Gagal', 'Tab yang dipilih tidak valid.');
            return;
        }

        $this->tab = $tab;

        if ($this->tab === 'odontogram') {
            $this->loadOdontogramData();
        }
    }

    public function loadOdontogramData()
    {
        // 1. Load Map (Current State)
        $details = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->user_id);
        })
            ->whereNotNull('odontogram_code')
            ->orderBy('created_at', 'asc') // Replay history to get final state
            ->get();

        $this->odontogram_map = [];
        foreach ($details as $detail) {
            if ($detail->odontogram_code) {
                $this->odontogram_map[$detail->odontogram_code] = $detail->odontogram_color ?? '#3b82f6';
            }
        }

        // 2. Load Most Frequent
        $frequent = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->user_id);
        })
            ->whereNotNull('odontogram_code')
            ->select('odontogram_code', \DB::raw('count(*) as total'))
            ->groupBy('odontogram_code')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $this->frequent_odontogram = $frequent;
    }

    public function hydrate()
    {
        $this->resetPage();
        $this->reset('search');
    }

    public function render()
    {
        return view('livewire.admin.consultation.patient.detail.admin-consultation-patient-detail-index', [
            'diagnosas' => $this->getDiagnosas(),
            'alergis' => $this->getAlergis(),
            'icd10s' => $this->getIcd10s(),
            'icd9s' => $this->getIcd9s(),
            'actions' => $this->getActions(),
            'proofs' => $this->getProofs(),
            'userControls' => $this->getUserControls(),
            'references' => $this->getReferences(),
            'recipes' => $this->getRecipes(),
            'products' => $this->getProducts(),
            'payments' => $this->getPayments(),
            'profits' => $this->getProfits(),
            'physicalexaminations' => $this->getPhysicalExaminations(),
            'historyOdontograms' => $this->getHistoryOdontograms(),
            'historyConsultations' => $this->getHistoryConsultations(),
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function getHistoryOdontograms()
    {
        return TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->user_id);
        })
            ->whereNotNull('odontogram_code')
            ->with(['transaction.doctor', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function getHistoryConsultations()
    {
        return Transaction::where('patient_id', $this->user_id)
            ->with(['doctor', 'poly'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function getPhysicalExaminations()
    {
        if ($this->tab !== 'observasi') {
            return collect();
        }

        return TransactionPhysicalExamination::select('id', 'transaction_id', 'heart_rate', 'breathing', 'blood_pressure_sistole', 'blood_pressure_diastole', 'body_temperature', 'height', 'weight', 'created_at')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->when($this->search, function ($query) {
                $query->where('heart_rate', 'ilike', '%' . $this->search . '%')
                    ->orWhere('breathing', 'ilike', '%' . $this->search . '%')
                    ->orWhere('blood_pressure_sistole', 'ilike', '%' . $this->search . '%')
                    ->orWhere('blood_pressure_diastole', 'ilike', '%' . $this->search . '%')
                    ->orWhere('body_temperature', 'ilike', '%' . $this->search . '%')
                    ->orWhere('height', 'ilike', '%' . $this->search . '%')
                    ->orWhere('weight', 'ilike', '%' . $this->search . '%');
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    // Method untuk setiap tab
    private function getDiagnosas()
    {
        if ($this->tab !== 'diagnosa') {
            return collect(); // Return empty collection instead of empty array
        }

        return TransactionDiagnosis::select('id', 'user_id', 'subjective', 'objective', 'assessment', 'plan', 'created_at')
            ->where('user_id', $this->user_id)
            ->where('company_id', auth()->user()->company_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('subjective', 'ilike', '%' . $this->search . '%')
                        ->orWhere('objective', 'ilike', '%' . $this->search . '%')
                        ->orWhere('assessment', 'ilike', '%' . $this->search . '%')
                        ->orWhere('plan', 'ilike', '%' . $this->search . '%');
                });
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getAlergis()
    {
        if ($this->tab !== 'alergi') {
            return collect();
        }

        return AllergyMedicine::select('id', 'user_id', 'company_id', 'description', 'created_at')
            ->where('user_id', $this->user_id)
            ->where('company_id', auth()->user()->company_id)
            ->when($this->search, function ($query) {
                $query->where('description', 'ilike', '%' . $this->search . '%');
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getIcd10s()
    {
        if ($this->tab !== 'icd-10') {
            return collect();
        }

        return TransactionIcd10::select('id', 'user_id', 'icd10_id', 'created_at')
            ->where('user_id', $this->user_id)
            ->where('company_id', auth()->user()->company_id)
            ->with('icd10:id,code,display,version')
            ->when($this->search, function ($query) {
                $query->whereHas('icd10', function ($q) {
                    $q->where('code', 'ilike', '%' . $this->search . '%')
                        ->orWhere('display', 'ilike', '%' . $this->search . '%')
                        ->orWhere('version', 'ilike', '%' . $this->search . '%');
                });
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getIcd9s()
    {
        if ($this->tab !== 'icd-9') {
            return collect();
        }

        return TransactionIcd9::select('id', 'user_id', 'icd9_id', 'created_at')
            ->where('user_id', $this->user_id)
            ->where('company_id', auth()->user()->company_id)
            ->with('icd9:id,code,display,version')
            ->when($this->search, function ($query) {
                $query->whereHas('icd9', function ($q) {
                    $q->where('code', 'ilike', '%' . $this->search . '%')
                        ->orWhere('display', 'ilike', '%' . $this->search . '%')
                        ->orWhere('version', 'ilike', '%' . $this->search . '%');
                });
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getActions()
    {
        if ($this->tab !== 'tindakan') {
            return collect();
        }

        return TransactionDetail::select('id', 'transaction_id', 'product_id', 'type_transaction', 'created_at', 'quantity', 'price', 'sub_total_price','name')
        ->whereNull('odontogram_code')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->where('type_transaction', 'action')
            ->with([
                'product:id,name,sku_number,product_type_id',
                'product.productType:id,name',
            ])
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'ilike', '%' . $this->search . '%');
                });
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getProofs()
    {
        if ($this->tab !== 'bukti-tindakan') {
            return collect();
        }

        return TransactionProofOfAction::select('id', 'transaction_id', 'date', 'before_photo', 'after_photo', 'description', 'created_at')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->when($this->search, function ($query) {
                $query->where('description', 'ilike', '%' . $this->search . '%')
                    ->orWhere('before_photo', 'ilike', '%' . $this->search . '%')
                    ->orWhere('after_photo', 'ilike', '%' . $this->search . '%');
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getUserControls()
    {
        if ($this->tab !== 'jadwal-kontrol') {
            return collect();
        }

        return UserControlSchedule::select('id', 'user_id', 'date', 'doctor_id', 'location_id', 'description', 'created_at')
            ->where('user_id', $this->user_id)
            ->where('company_id', auth()->user()->company_id)
            ->with([
                'doctor:id,name',
                'poly:id,name'
            ])
            ->when($this->search, function ($query) {
                $query->where('description', 'ilike', '%' . $this->search . '%')
                    ->orWhereHas('doctor', function ($q) {
                        $q->where('name', 'ilike', '%' . $this->search . '%');
                    })
                    ->orWhereHas('location', function ($q) {
                        $q->where('name', 'ilike', '%' . $this->search . '%');
                    });
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getReferences()
    {
        if ($this->tab !== 'rujukan') {
            return collect();
        }

        return TransactionReference::select('id', 'transaction_id', 'date', 'doctor_name', 'hospital', 'description', 'created_at')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->when($this->search, function ($query) {
                $query->where('description', 'ilike', '%' . $this->search . '%')
                    ->orWhere('doctor_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('hospital', 'ilike', '%' . $this->search . '%');
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getRecipes()
    {
        if ($this->tab !== 'resep') {
            return collect();
        }

        return TransactionRecipe::select('id', 'transaction_id', 'medicine_type_id', 'numero_recipe', 'price_service_one', 'product_id', 'quantity', 'price', 'sub_total_price', 'description', 'created_at')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->with([
                'product:id,name,sku_number,product_type_id',
                'medicineType:id,name,is_single',
                'transaction:id,patient_id',
                'transactionDetail' => function ($query) {
                    $query->select('id', 'transaction_recipe_id', 'type', 'dosage_doctor', 'doctor_dosage_gram', 'dosage_drug', 'product_id', 'quantity', 'price', 'sub_total_price', 'quantity_real')
                        ->with('product:id,name,sku_number,product_type_id');
                },
            ])
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    public function getPayments()
    {
        if ($this->tab !== 'terima-bayar') {
            return collect();
        }

        return TransactionPayment::select('id', 'transaction_id', 'payment_method_id', 'payment_amount', 'payment_real', 'admin_fee', 'created_at')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->when($this->search, function ($query) {
                $query->where('payment_real', 'ilike', '%' . $this->search . '%')
                    ->orWhere('payment_amount', 'ilike', '%' . $this->search . '%')
                    ->orWhereHas('transaction', function ($query) {
                        $query->where('code', 'ilike', '%' . $this->search . '%');
                    })->orWhereHas('paymentMethod', function ($query) {
                        $query->where('name', 'ilike', '%' . $this->search . '%');
                    });
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getProducts()
    {
        if ($this->tab !== 'penjualan') {
            return collect();
        }

        return TransactionProduct::select('id', 'transaction_id', 'product_id', 'quantity', 'price', 'total', 'created_at')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->with(['product:id,name,sku_number,product_type_id', 'product.productType:id,name'])
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'ilike', '%' . $this->search . '%');
                });
            })
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);
    }

    private function getProfits()
    {
        if ($this->tab !== 'laba-rugi') {
            return collect();
        }

        return TransactionProduct::search($this->search)
            ->selectRaw('
                product_id,
                product_name,
                SUM(quantity) as total_quantity,
                SUM(price) as total_price,
                SUM(total) as total_penjualan,
                SUM(hpp_average) as total_hpp_average,
                SUM(hpp_total) as total_hpp_total,
                SUM(profit) as total_profit,
                AVG(margin) as average_margin
        ')
            ->whereIn('transaction_id', $this->transactions)
            ->where('company_id', auth()->user()->company_id)
            ->with('product:id,name,sku_number,product_type_id', 'product.productType:id,name')
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed');

                // if ($this->type) {
                //     $query->where('type', $this->type);
                // }
            })
            // ->when($this->start_date && $this->end_date, function ($query) {
            //     $query->whereBetween('created_at', [
            //         $this->start_date . ' 00:00:00',
            //         $this->end_date . ' 23:59:59'
            //     ]);
            // })
            // ->when($this->product_id, function ($query) {
            //     $query->where('product_id', $this->product_id);
            // })
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_quantity', 'desc')
            ->paginate($this->perPage);
    }
}
