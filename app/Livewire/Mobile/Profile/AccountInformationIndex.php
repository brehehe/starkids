<?php

namespace App\Livewire\Mobile\Profile;

use Livewire\Component;

class AccountInformationIndex extends Component
{
    public function render()
    {
        return view('livewire.mobile.profile.account-information-index')->layout('layout.mobile.app-mobile', [
            'activeTab'  => 'profile',
            'title' => 'Profile',
            'showHeader' => false, // login tanpa topbar
            'showBottom' => false,
        ]);
    }
}
