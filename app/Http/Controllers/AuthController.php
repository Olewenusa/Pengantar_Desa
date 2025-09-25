<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Http\RedirectResponse;
use App\Models\User; 


class AuthController extends Controller
{

    public function login(Request $request)
    {

        if(auth::check()){
            return back();
        }
        return view('pages.auth.login');
    }

    public function authenthicate(Request $request)
    {

        if(auth::check()){
            return back();
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userstatus = Auth::user()->status;

            if($userstatus == 'submitted'){
                $this->_logout($request);
                return back()->withErrors(['email'=> 'Akun anda belum di setujui oleh admin']);
            }else if($userstatus == 'rejected'){
                $this->_logout($request);
                return back()->withErrors(['email'=> 'Akun anda ditolak, silahkan hubungi admin']);
            }
           
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'Terjadi kesalahan, periksa kembali data anda.',
        ])->onlyInput('email');
    }

    public function registerView()
    {
        if(auth::check()){
            return back();
        }

        $wilayahData = [
            '01' => 7, // RW 01 ada 5 RT
            '02' => 9, // RW 02 ada 4 RT
            '03' => 3, // RW 03 ada 3 RT
            '04' => 10, // RW 04 ada 3 RT
            '05' => 10, // RW 05 ada 3 RT
            '06' => 7, // RW 06 ada 3 RT
            '07' => 4, // RW 07 ada 3 RT
            '08' => 8, // RW 08 ada 3 RT
            '09' => 7, // RW 09 ada 3 RT
            '10' => 2, // RW 10 ada 3 RT

            
        ];
        return view('pages.auth.register', compact('wilayahData'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'rw' => 'required',
            'rt' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rw' => $request->rw,
            'rt' => $request->rt,
            'status' => 'submitted',
            'role_id' => 2,
        ]);

        return redirect('/')->with('success', 'Berhasil mendaftar, menunggu persetujuan admin.');
    }

    public function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
    public function logout(Request $request): RedirectResponse
    {
        if(!auth::check()){
            return redirect('/');
        }

        $this->_logout($request);
    
        return redirect('/');
    }
}
