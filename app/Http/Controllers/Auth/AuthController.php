<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:siswa')->except('logout');
        $this->middleware('guest:guru')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $password = hash("sha512", md5($request->password));
        $passwords = md5($request->password);

        $credential = [
            'password' => $request->password,
        ];

        $user = User::where('username', $request->username)->where('password', $password)->first();
        $siswa = Siswa::where('nisn', $request->username)->where('password', $passwords)->first();
        $guru = Guru::where('nip', $request->username)->where('password', $passwords)->first();
        if ($user) {
            $credential['username'] = $request->username;
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
        } else if ($siswa) {
            $credential['nisn'] = $request->username;
            config()->set('auth.defaults.guard', 'siswa');
            Auth::login($siswa);
            Auth::guard('siswa')->attempt($credential, $request->filled('remember'));
            session(['level_user' => 'siswa']);
            return redirect('user/siswa');
        } else if ($guru) {
            config()->set('auth.defaults.guard', 'guru');
            $credential['nip'] = $request->username;
            Auth::login($guru);
            Auth::guard('guru')->attempt($credential, $request->filled('remember'));
            session(['level_user' => 'guru']);
            return redirect('user/guru');
        }

        Auth::guard('admin')->logout();
        Auth::guard('siswa')->logout();
        Auth::guard('guru')->logout();
        return redirect()->back()->withInput($request->only('username', 'password'))->withErrors(['error' => ['Username atau password yang anda masukkan salah!']]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }
}
