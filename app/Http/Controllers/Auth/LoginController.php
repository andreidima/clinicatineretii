<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // Verify if the user is activ
            if ($user = User::where('email', $request->email)->first()){
                if ($user->activ == 0) {
                    Auth::logout();

                    $request->session()->invalidate();

                    $request->session()->regenerateToken();

                    return redirect()->route('login')->with('error', 'Acest cont nu este activ. Contactează administratorul.');
                }
            }

            $request->session()->regenerate();

            return redirect()->intended('acasa');
        }

        return back()->with('error', 'Nu există un cont cu aceste date de conectare în baza de date.')->onlyInput('email');
    }
}
