<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'ab_mail' => 'required|email',
            'ab_password' => 'required',
        ]);

        $user = AbUser::where('ab_mail', $credentials['ab_mail'])->first();


        // Attempt to log in
        if (Hash::check($credentials['ab_password'], $user?->ab_password))
        {
            // Regenerate session for security
            $request->session()->regenerate();
            // Log them in
            Auth::login($user);

            // Redirect to intended page or home
            return redirect('/')->with('success', 'Welcome back!');
        }

        // If login fails, redirect back with error
        return back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->onlyInput('email');
    }

}
