<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CustomerLogin extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        $customer = Customer::where('email', $this->email)->first();

        if ($customer && Hash::check($this->password, $customer->password)) {
            Auth::guard('customer')->login($customer);
            $customer->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
            ]);

            return redirect()->route('home');
        } else {
            session()->flash('error', 'Invalid credentials');
        }
    }

    public function render()
    {
        return view('livewire.customer-login');
    }
}
