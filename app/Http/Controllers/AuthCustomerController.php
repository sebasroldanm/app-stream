<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthCustomerController extends Controller
{
    public function index() {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            Auth::guard('customer')->login($customer);
            $customer->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
            ]);

            return redirect()->route('home');
        }

        // Si la autenticación falla, redirigir de vuelta con un error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('customer')->logout();  // Cierra la sesión del usuario
        return redirect()->route('customer.login');
    }
}
