<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class AuthAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin/login');
    }

    public function login(Request $request)
    {
        
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $credential = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $password = hash("sha512", md5($request->password));
        $passwords = md5($request->password);

        $user = User::where('username', $request->username)->where('password', $password)->first();
        if ($user) {
            config()->set('auth.defaults.guard', 'admin');
            Auth::login($user);
            Auth::guard('admin')->attempt($credential, $request->filled('remember'));
            if ($user->is_skl) {
                session(['identitas_sekolah' => $user->is_skl]);
                return redirect('admin/' . $user->is_skl->keyword);
            } else {
                session(['superadmin' => true]);
                return redirect('set-sys');
            }
            
        }

        Auth::guard('admin')->logout();
        return redirect()->back()->withInput($request->only('username', 'password'))->withErrors(['error' => ['Username atau password yang anda masukkan salah!']]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }
}
