<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Mail\ResetPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->permission == 1) {
                $request->session()->regenerate();

                return redirect()->intended('admin/dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'permission' => 2,
            'remember_token' => Str::random(30),
            'password' => bcrypt($request->password),
        ]);

        // Mail::to($user->email)->send(new EmailVerification($user));

        try {
            return redirect()->route('verifyNotification');
        } catch (\Exception $ex) {
            return redirect()->back();
        }
    }

    public function registerVerify($token)
    {
        $user = User::where('remember_token', $token)->first();
        if ($token == null) {
            session()->flash('type', 'warning');
            session()->flash('message', 'Invalid token');

            return redirect()->route('login');
        }

        if ($user == null) {
            session()->flash('type', 'warning');
            session()->flash('message', 'You are not register');

            return redirect()->route('login');
        }

        $user->update([
            'email_verified_at' => Carbon::now(),
            'remember_token' => null,
        ]);

        session()->flash('type', 'info');
        session()->flash('message', 'Your account is activated. You can login now');

        return redirect()->route('login');
    }

    public function verifyNotification()
    {
        return view('auth.verify');
    }

    public function verifyResend(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Invalid email');

            return redirect()->back();
        }
        $data['remember_token'] = Str::random(40);
        $user->update($data);
        Mail::to($request->email)->send(new EmailVerification($user));

        return redirect()->route('verifyNotification');
    }

    public function forgetPassword()
    {
        return view('auth.forget_password');
    }

    public function forgetPasswordProcess(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Invalid email');

            return redirect()->back();
        }
        $forgetData = PasswordReset::create([
            'email' => $request->email,
            'token' => Str::random(40),
        ]);

        Mail::to($request->email)->send(new ResetPassword($forgetData));

        return redirect()->route('resetVerifyNotification');
    }

    public function resetPassword($token)
    {
        $user = PasswordReset::where('token', $token)->first();

        return view('auth.reset_password', compact('user'));
    }

    public function resetPasswordProcess(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', Password::min(6)->letters()->numbers()->symbols()->uncompromised()],
        ]);

        $data = [
            'password' => bcrypt($request->get('password')),
        ];

        User::where('email', $request->email)->update($data);
        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('login');
    }

    public function resetVerifyNotification()
    {
        return view('auth.reset_verify');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login');
    }
}
