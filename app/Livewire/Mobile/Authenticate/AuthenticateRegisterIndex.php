<?php

namespace App\Livewire\Mobile\Authenticate;

use Livewire\Component;

class AuthenticateRegisterIndex extends Component
{
    public function render()
    {
        return view('livewire.mobile.authenticate.authenticate-register-index')->layout('layout.mobile.app-mobile', [
            'title' => 'Register',
            'showHeader' => false, // login tanpa topbar
            'showBottom' => false,
        ]);
    }
}
