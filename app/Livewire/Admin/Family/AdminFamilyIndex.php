<?php

namespace App\Livewire\Admin\Family;

use App\Models\Family\Family;
use App\Models\Family\FamilyMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminFamilyIndex extends Component
{
    use WithPagination;

    public $search;

    public $family;

    public $family_id;

    public $search_member;

    public $user_results = [];

    public $selected_user_id;

    public $selected_user;

    public $relationship;

    public $is_modal_open = false;

    public $foundUser = null;

    public function render()
    {
        return view('livewire.admin.family.family-index')
            ->extends('layout.app')
            ->section('content');
    }

    public $search_results = [];

    public function updatedSearch()
    {
        $this->reset('foundUser', 'family', 'family_id', 'search_results');

        // Search by RM or NIK
        if (strlen($this->search) < 3) {
            return;
        }

        // Perform search across multiple fields and return collection
        $this->search_results = User::where('name', 'ilike', '%'.$this->search.'%')
            ->orWhere('email', 'ilike', '%'.$this->search.'%')
            ->orWhereHas('companyRoles', function ($q) {
                $q->where('medical_record_number', 'ilike', '%'.$this->search.'%')
                    ->where('company_id', auth()->user()->company_id);
            })
            ->orWhereHas('userDetail', function ($q) {
                $q->where('identity_card', 'ilike', '%'.$this->search.'%');
            })
            ->with(['companyRoles' => function ($q) {
                $q->where('company_id', auth()->user()->company_id);
            }, 'userDetail'])
            ->take(10)
            ->get();
    }

    public function selectPatient($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->search = $user->name; // Update search input with selected name
            $this->search_results = []; // Clear results
            $this->loadFamily($user);
        }
    }

    public function updatedSearchMember()
    {
        if (strlen($this->search_member) < 3) {
            $this->user_results = [];

            return;
        }

        $this->user_results = User::where('name', 'ilike', '%'.$this->search_member.'%')
            ->orWhere('email', 'ilike', '%'.$this->search_member.'%')
            ->orWhereHas('companyRoles', function ($q) {
                $q->where('medical_record_number', 'ilike', '%'.$this->search_member.'%')
                    ->where('company_id', auth()->user()->company_id);
            })
            ->orWhereHas('userDetail', function ($q) {
                $q->where('identity_card', 'ilike', '%'.$this->search_member.'%');
            })
            ->with(['companyRoles' => function ($q) {
                $q->where('company_id', auth()->user()->company_id);
            }])
            ->take(10)
            ->get();
    }

    public function selectMember($userId)
    {
        $this->selected_user = User::with(['companyRoles' => function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        }, 'userDetail'])->find($userId);

        $this->selected_user_id = $this->selected_user->id;
        $this->search_member = $this->selected_user->name;
        $this->user_results = [];
    }

    public function cancelSelection()
    {
        $this->reset('selected_user', 'selected_user_id', 'search_member');
    }

    public function loadFamily($user)
    {
        // Check if user has a family
        $familyMember = FamilyMember::where('user_id', $user->id)->first();

        if ($familyMember) {
            $this->family = Family::with(['members.user.companyRoles' => function ($q) {
                $q->where('company_id', auth()->user()->company_id);
            }, 'headUser'])->find($familyMember->family_id);
            $this->family_id = $this->family->id;
            $this->foundUser = null;
        } else {
            // User found but no family yet
            $this->family = null;
            $this->foundUser = $user;
        }
    }

    public function createFamilyForUser($userId)
    {
        $user = User::find($userId);
        if (! $user) {
            return;
        }

        DB::transaction(function () use ($user) {
            $family = Family::create([
                'name' => 'Keluarga '.$user->name,
                'head_user_id' => $user->id,
                'company_id' => $user->company_id ?? auth()->user()->company_id,
            ]);

            FamilyMember::create([
                'family_id' => $family->id,
                'user_id' => $user->id,
                'relationship' => 'kepala_keluarga',
                'company_id' => $family->company_id,
            ]);

            $this->family = $family->fresh(['members.user.companyRoles' => function ($q) {
                $q->where('company_id', auth()->user()->company_id);
            }, 'headUser']);
            $this->family_id = $family->id;
        });
    }

    public function addMember()
    {
        $this->validate([
            'selected_user_id' => 'required',
            'relationship' => 'required',
        ]);

        if (! $this->family) {
            return;
        }

        // Check if user is already in a family
        $existing = FamilyMember::where('user_id', $this->selected_user_id)->first();
        if ($existing) {
            $this->addError('selected_user_id', 'User sudah terdaftar di keluarga lain.');

            return;
        }

        FamilyMember::create([
            'family_id' => $this->family->id,
            'user_id' => $this->selected_user_id,
            'relationship' => $this->relationship,
            'company_id' => $this->family->company_id,
        ]);

        $this->family->load(['members.user.companyRoles' => function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        }, 'headUser']);
        $this->reset('selected_user_id', 'relationship', 'search_member', 'user_results', 'is_modal_open');
    }

    public function removeMember($memberId)
    {
        FamilyMember::destroy($memberId);
        $this->family->load(['members.user.companyRoles' => function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        }, 'headUser']);
    }

    public function setHead($memberId)
    {
        $member = FamilyMember::find($memberId);
        if (! $member || $member->family_id !== $this->family->id) {
            return;
        }

        DB::transaction(function () use ($member) {
            $this->family->update(['head_user_id' => $member->user_id]);

            // Update relationships? Maybe not strictly necessary if just flagging head
            // But usually head is 'kepala_keluarga'
            $member->update(['relationship' => 'kepala_keluarga']);

            // Should we demote previous head?
            // For now, let's just set the head_user_id
        });

        $this->family->load(['members.user.companyRoles' => function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        }, 'headUser']);
    }
}
