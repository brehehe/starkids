<?php

namespace App\Livewire\Queue;

use App\Models\Company\Company;
use App\Models\Location\Location;
use App\Traits\Company\CompanyTrait;
use Carbon\Carbon;
use Livewire\Component;

class QueueIndex extends Component
{
    use CompanyTrait;

    public $selectedBranch = null;

    public $selectedBranchData = null;

    public $selectedPoly = null;

    public $companies = [];

    public $branches = [];

    public $polies = [];

    public function mount()
    {
        $this->companies = $this->getCompanyBranches(Company::orderBy('order', 'ASC')->first()?->id);
        $this->branches = $this->getBranches();
        // dd($this->branches);
    }

    public function selectBranch($branchId)
    {
        // dd($branchId);
        $this->selectedBranch = $branchId;
        $this->selectedPoly = null; // Reset poli selection when branch changes
        $this->getPolies($branchId);
    }

    public function selectPoly($polyId)
    {
        $this->selectedPoly = $polyId;
    }

    public function refreshQueue()
    {
        // Method to refresh queue data - can be enhanced with real data
        $this->dispatch('queueRefreshed');
    }

    protected $listeners = ['refreshQueue'];

    private function getBranches()
    {
        $this->branches = $locations = [];
        foreach ($this->companies ?? [] as $key => $company) {
            $this->branches[] = [
                'id' => $company?->id, // Assuming $key is the index for branch <ID></ID>
                'name' => $company?->name,
                'city' => $company?->city,
                'address' => $company?->companyDetail?->address,
                'phone' => $company?->phone,
                'image' => $company?->image,
                'hours' => $company?->hours,
                'distance' => $company?->distance,
                'specialties' => Location::where('company_id', $company?->id)->pluck('name')->toArray(),
                'current_queue' => $company?->transactions()->whereIn('status', ['consultation'])->whereDate('date', Carbon::now())->first()?->code ?? '--',
                'waiting_queue' => $company?->transactions()->whereIn('status', ['waiting_consultation', 'draft_consultation', 'call_consultation', 'confirmation_call'])->whereDate('date', Carbon::now())->count(),
                'total_queue' => $company?->transactions()->whereIn('status', ['pharmacy', 'call_pharmacy', 'sale_pharmacy', 'draft', 'process', 'take_medicine', 'completed'])->whereDate('date', Carbon::now())->count(),
            ];
        }

        return $this->branches;
        // return [
        //     [
        //         'id' => 1,
        //         'name' => 'Klinik Sehat Mandiri Pusat',
        //         'city' => 'Jakarta Pusat',
        //         'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
        //         'phone' => '(021) 1234-5678',
        //         'image' => 'img/branch-1.jpg',
        //         'hours' => 'Senin - Sabtu: 08:00 - 20:00',
        //         'distance' => '2.5 km',
        //         'specialties' => ['Umum', 'Anak', 'Mata'],
        //         'total_queue' => 12,
        //         'current_queue' => 'A005',
        //         'waiting_queue' => 7
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Klinik Sehat Mandiri Selatan',
        //         'city' => 'Jakarta Selatan',
        //         'address' => 'Jl. Kemang Raya No. 456, Jakarta Selatan',
        //         'phone' => '(021) 2345-6789',
        //         'image' => 'img/branch-2.jpg',
        //         'hours' => 'Senin - Sabtu: 08:00 - 20:00',
        //         'distance' => '3.8 km',
        //         'specialties' => ['Umum', 'Jantung', 'Bedah'],
        //         'total_queue' => 8,
        //         'current_queue' => 'B003',
        //         'waiting_queue' => 5
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'Klinik Sehat Mandiri Utara',
        //         'city' => 'Jakarta Utara',
        //         'address' => 'Jl. Pantai Indah No. 789, Jakarta Utara',
        //         'phone' => '(021) 3456-7890',
        //         'image' => 'img/branch-3.jpg',
        //         'hours' => 'Senin - Sabtu: 08:00 - 20:00',
        //         'distance' => '5.2 km',
        //         'specialties' => ['Umum', 'Kulit', 'THT'],
        //         'total_queue' => 15,
        //         'current_queue' => 'C007',
        //         'waiting_queue' => 8
        //     ]
        // ];
    }

    private function getPolies($branchId = null)
    {
        $this->polies = [];
        if (! $branchId) {
            return [];
        }

        $locations = Location::where('company_id', $branchId)->get();
        foreach ($locations as $location) {
            $this->polies[] = [
                'id' => $location->id,
                'name' => $location->name,
                'description' => $location->description,
                'icon' => $location->icon, // Assuming icon is a field in Location
                'current_queue' => $location->transactions()->whereIn('status', ['consultation'])->whereDate('date', Carbon::now())->first()?->code ?? '--',
                'waiting_count' => $location->transactions()->whereIn('status', ['waiting_consultation', 'draft_consultation', 'call_consultation', 'confirmation_call'])->whereDate('date', Carbon::now())->count(),
                'served_today' => $location->transactions()->whereIn('status', ['pharmacy', 'call_pharmacy', 'sale_pharmacy', 'draft', 'process', 'take_medicine', 'completed'])->whereDate('date', Carbon::now())->count(),
                'doctor' => $location->doctor_name, // Assuming doctor_name is a field in Location
            ];
        }
    }

    public function render()
    {
        $branches = $this->getBranches();

        if ($this->selectedBranch) {
            foreach ($branches as $branch) {
                if ($branch['id'] == $this->selectedBranch) {
                    $this->selectedBranchData = $branch;
                    break;
                }
            }
        }

        return view('livewire.queue.queue-index', [
            // 'branches' => $branches,
            // 'polies' => $this->getPolies($this->selectedBranch),
        ])->extends('layout.queue.app');
    }
}
