<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerLogout extends Component
{

    public function logout() {
        Auth::guard('customer')->logout();  // Cierra la sesión del usuario

        // Redirige al usuario a la página de login
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.customer-logout');
    }
}
