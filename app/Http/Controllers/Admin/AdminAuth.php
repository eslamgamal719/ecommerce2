<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminAuth extends Controller
{
    public function login()
    {
        return view('dashboard.login');
    }


    public function doLogin()
    {
        $remeber_me = request('rememberme') == 1 ? true : false;

        if (auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')], $remeber_me)) {

            return redirect('admin');

        } else {

            session()->flash('error', __('admin.incorrect information'));

            return redirect('admin/login');
        }
    }


    public function logout()
    {
        auth()->guard()->logout();
        return redirect()->route('login');
    }



    public function forgotPassword()
    {
        return view('dashboard.forgot_password');
    }


    public function postForgotPassword()
    {
        $admin = Admin::where('email', request('email'))->first();

        if (!empty($admin)) {

            $token = app('auth.password.broker')->createToken($admin);

             DB::table('password_resets')->insert([
                'email' => $admin->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::To($admin->email)->send(new AdminResetPassword(['admin' => $admin, 'token' => $token]));
            session()->flash('success', 'Link reset is sent');
            return redirect()->back();

        }

        return redirect()->back();
    }


    public function resetPassword($token)
    {
        $checkToken = DB::table('password_resets')
            ->where('token', $token)               //now - 2hr
            ->where('created_at', '>', Carbon::now()->subHours(2))
            ->first();

        if (!empty($checkToken)) {
            return view('dashboard.reset_password', ['data' => $checkToken]);
        }

    }

    public function postResetPassword($token)
    {

        $this->validate(request(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $checkToken = DB::table('password_resets')
            ->where('token', $token)
            ->where('created_at', '>', Carbon::now()->subHours(2))
            ->first();

        if (!empty($checkToken)) {

            $admin = Admin::where('email', $checkToken->email)->update(['password' => bcrypt(request('password'))]);

            DB::table('password_resets')->where('email', request()->email)->delete();

            admin()->attempt(['email' => $checkToken->email, 'password' => request('password')], true);

            return redirect()->route('admin');
        }else {
            return redirect()->route('forgot.password');
        }

    }
}
