<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttemptLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(AttemptLoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = User::where('mobile', $request->mobile)->first();
            Auth::login($user, 1);
            return redirect()->route('admin.index');
        }
 
        return back()->withErrors([
            'mobile' => 'مشخصات وارد شده صحیح نمی‌باشد.',
        ])->onlyInput('mobile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
