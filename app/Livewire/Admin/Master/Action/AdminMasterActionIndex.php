<?php

namespace App\Livewire\Admin\Master\Action;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Doctor\DoctorActionIncentive;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductType;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AdminMasterActionIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    public $search = '';
    public $perPage = 5;
    public $data_id = null;
    public $name;
    public $description;
    public $hpp_average;
    public $product_type_id;
    public $price;
    public $type_incentive_nurse;
    public $type_incentive_doctor;
    public $incentive_nurse;
    public $incentive_doctor;

    // Per-doctor incentive
    public array $doctor_incentives = [];       // [{doctor_id, doctor_name, type_incentive, incentive_value, id?}]
    public string $di_doctor_id   = '';
    public string $di_type        = 'rupiah';
    public string $di_value       = '0';

    /**
     * Hitung insentif dokter default (global) dalam Rp.
     */
    #[Computed]
    public function doctorIncentiveCalculated(): int
    {
        $priceClean    = intval(Str::replace('.', '', $this->price ?? '0'));
        $incentiveClean = intval(Str::replace('.', '', $this->incentive_doctor ?? '0'));

        if ($this->type_incentive_doctor === 'percentage') {
            return (int) round($priceClean * $incentiveClean / 100);
        }
        return $incentiveClean;
    }

    public function mount()
    {
        $this->product_type_id = ProductType::where('name', 'Tindakan')->first()->id;
    }

    public function openModal()
    {
        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal($modal)
    {
        $this->reset([
            'data_id',
            'name',
            'description',
            'hpp_average',
            'price',
            'type_incentive_nurse',
            'type_incentive_doctor',
            'incentive_nurse',
            'incentive_doctor',
            'doctor_incentives',
            'di_doctor_id',
            'di_type',
            'di_value',
        ]);
        return $this->dispatch('close-modal', ['id' => $modal]);
    }

    public function edit($id)
    {
        $this->data_id = $id;
        $product = Product::find($id);
        if ($product) {
            $this->name                  = $product->name;
            $this->description           = $product->description;
            $this->product_type_id       = $product->product_type_id;
            $this->type_incentive_nurse  = $product->type_incentive_nurse;
            $this->type_incentive_doctor = $product->type_incentive_doctor;
            $this->incentive_doctor      = $product->incentive_doctor;
            $this->incentive_nurse       = $product->incentive_nurse;

            $productPrice = ProductPrice::where('product_id', $id)
                ->where('company_id', auth()->user()->company_id)
                ->where('is_updated', true)
                ->first();
            if ($productPrice) {
                $this->hpp_average = number_format($productPrice->hpp_average, 0, ',', '.');
                $this->price       = number_format($productPrice->price, 0, ',', '.');
            }

            // Muat per-doctor incentives
            $this->loadDoctorIncentives();
        }
        $this->openModal();
    }

    protected function loadDoctorIncentives(): void
    {
        $rows = DoctorActionIncentive::where('product_id', $this->data_id)
            ->with('user:id,name')
            ->get();

        $priceClean = intval(Str::replace('.', '', $this->price ?? '0'));

        $this->doctor_incentives = $rows->map(function ($row) use ($priceClean) {
            $calculated = $row->type_incentive === 'percentage'
                ? (int) round($priceClean * $row->incentive_value / 100)
                : (int) $row->incentive_value;

            return [
                'id'              => $row->id,
                'user_id'         => $row->user_id,
                'doctor_name'     => $row->user->name ?? '-',
                'type_incentive'  => $row->type_incentive,
                'incentive_value' => $row->incentive_value,
                'calculated'      => $calculated,
            ];
        })->values()->toArray();
    }

    public function addDoctorIncentive(): void
    {
        $this->validate([
            'di_doctor_id' => 'required|exists:users,id',
            'di_type'      => 'required|in:percentage,rupiah',
            'di_value'     => 'required|numeric|min:0',
        ], [
            'di_doctor_id.required' => 'Pilih dokter terlebih dahulu.',
            'di_doctor_id.exists'   => 'Dokter tidak ditemukan.',
            'di_value.required'     => 'Nilai insentif wajib diisi.',
        ]);

        $valueClean = floatval(Str::replace('.', '', $this->di_value));

        if ($this->di_type === 'percentage' && $valueClean > 100) {
            $this->addError('di_value', 'Persentase tidak boleh melebihi 100%.');
            return;
        }

        DoctorActionIncentive::updateOrCreate(
            [
                'product_id' => $this->data_id,
                'user_id'    => $this->di_doctor_id,
            ],
            [
                'type_incentive'  => $this->di_type,
                'incentive_value' => $valueClean,
                'company_id'      => auth()->user()->company_id,
            ]
        );

        $this->reset(['di_doctor_id', 'di_type', 'di_value']);
        $this->di_type  = 'rupiah';
        $this->di_value = '0';
        $this->loadDoctorIncentives();
        AlertHelper::success('Berhasil', 'Insentif dokter berhasil disimpan.');
    }

    public function removeDoctorIncentive(string $incentiveId): void
    {
        DoctorActionIncentive::find($incentiveId)?->delete();
        $this->loadDoctorIncentives();
    }

    public function save()
    {
        $this->validate([
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string|max:1000',
            'hpp_average'           => 'required',
            'price'                 => 'required',
            'type_incentive_nurse'  => 'required|in:percentage,rupiah',
            'type_incentive_doctor' => 'required|in:percentage,rupiah',
            'incentive_nurse'       => 'nullable',
            'incentive_doctor'      => 'nullable',
        ]);

        $product = Product::updateOrCreate(
            ['id' => $this->data_id],
            [
                'name'                  => $this->name,
                'description'           => $this->description,
                'product_type_id'       => $this->product_type_id,
                'company_id'            => auth()->user()->company_id,
                'is_non_stock'          => true,
                'branch_id'             => Branch::where('company_id', auth()->user()->company_id)->first()->id ?? null,
                'type_incentive_nurse'  => $this->type_incentive_nurse,
                'type_incentive_doctor' => $this->type_incentive_doctor,
                'incentive_nurse'       => intval(Str::replace('.', '', $this->incentive_nurse)),
                'incentive_doctor'      => intval(Str::replace('.', '', $this->incentive_doctor)),
            ]
        );

        ProductPrice::updateOrCreate(
            [
                'product_id' => $product->id,
                'company_id' => auth()->user()->company_id,
                'branch_id'  => Branch::where('company_id', auth()->user()->company_id)->first()->id ?? null,
            ],
            [
                'hpp_average' => intval(Str::replace('.', '', $this->hpp_average)),
                'price'       => intval(Str::replace('.', '', $this->price)),
                'is_updated'  => true,
            ]
        );

        $this->closeModal('modal');
        return AlertHelper::success('Berhasil', 'Data tindakan berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus tindakan ini?', $id);
    }

    public function delete($id)
    {
        $product = Product::find($id[0]);
        if ($product) {
            $product->delete();
            return AlertHelper::success('Berhasil', 'Tindakan berhasil dihapus.');
        }
        return AlertHelper::error('Gagal', 'Tindakan tidak ditemukan.');
    }

    public function render()
    {
        $products = Product::where('product_type_id', $this->product_type_id)
            ->select('id', 'name', 'description')
            ->where('is_non_stock', true)
            ->with(['productPrice:product_id,hpp_average,price'])
            ->search($this->search)
            ->orderBy('name');

        // Daftar dokter: ambil dari users dengan tipe karyawan yang memiliki akses dokter
        $doctors = User::where('company_id', auth()->user()->company_id)
            ->where('type_user', 'employee')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.admin.master.action.admin-master-action-index', [
            'products'                    => $products->paginate($this->perPage),
            'doctors'                     => $doctors,
            'doctorIncentiveCalculated'   => $this->doctorIncentiveCalculated,
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function updatedTypeIncentiveDoctor()
    {
        $this->incentive_doctor = 0;
    }

    public function updatedTypeIncentiveNurse()
    {
        $this->incentive_nurse = 0;
    }

    public function updatedIncentiveDoctor()
    {
        $incentive_doctor = intval(Str::replace('.', '', $this->incentive_doctor));
        if ($this->type_incentive_doctor == 'percentage' && $incentive_doctor > 100) {
            $this->incentive_doctor = 100;
        } else {
            $this->incentive_doctor = number_format($incentive_doctor, 0, ',', '.');
        }
    }

    public function updatedIncentiveNurse()
    {
        $incentive_nurse = intval(Str::replace('.', '', $this->incentive_nurse));
        if ($this->type_incentive_nurse == 'percentage' && $incentive_nurse > 100) {
            $this->incentive_nurse = 100;
        } else {
            $this->incentive_nurse = number_format($incentive_nurse, 0, ',', '.');
        }
    }

    public function updatedDiType()
    {
        $this->di_value = '0';
    }
}
