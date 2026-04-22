<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\SyncData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthCustomerController extends Controller
{
    use SyncData;

    public function index()
    {
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        // Validar campos
        $request->validate([
            'username' => 'required|string|max:255|unique:customers,username',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8',
        ]);

        $customer = Customer::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        $remember = $request->has('remember');

        if ($customer && Hash::check($request->password, $customer->password)) {
            Auth::guard('customer')->login($customer, $remember);
            $customer->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
            ]);

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => __('The credentials do not match our records.'),
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('customer')->logout();  // Cierra la sesión del usuario
        return redirect()->route('login');
    }

    public function test(Request $request)
    {
        return;
    }
    

    public function search(Request $request)
    {
        $echo = $request->all();

        $request->validate([
            'q' => 'required',
        ]);

        $keyword = $request->q;

        $response = $this->searchGlobal($keyword);

        return response()->json($response);
    }
}
