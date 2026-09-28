<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Handles authenticating users for the application and redirecting them
    | to their role-appropriate home screen. Login throttling is provided by
    | the AuthenticatesUsers trait (5 attempts, 1 minute decay).
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login (non-admins).
     *
     * @var string
     */
    protected $redirectTo = '/my-account';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * Administrators always land on the Admin Dashboard after login; they are
     * never sent to the storefront or an intended URL. All other roles keep
     * their normal redirect behaviour.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed                    $user
     * @return \Illuminate\Http\RedirectResponse|null
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            // Discard any "intended" URL so the dashboard always wins.
            $request->session()->forget('url.intended');

            return redirect()->route('admin.dashboard');
        }

        return null;
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
