<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function account_requests_view() 
    {
        $users =  User::where('status', 'submitted')->get();

        return view('pages.account_requests.index',
    [
        'users' => $users,
    ]);
    }

    public function account_approval (Request $request, $userid)
    {
        $request ->validate
        ([
            'for' => 'required|in:approved,reject,activate,deactivate',
        ]);

        $for = $request->input('for');
        $user = User::findOrFail($userid);
        $user -> status = $for =='approved' || $for=='activate' ? 'approved' : 'rejected';
        $user->save();
        
        if ($for == 'activate')
            {
             return back()->with('success', 'Berhasil mengaktifkan akun' );    
            } else if ($for == 'deactivate')
            {
             return back()->with('success', 'Berhasil menonaktifkan akun' );    
            }

        return back()->with('success',$for == 'approved' ? 'Akun berhasil disetujui' : 'Akun berhasil ditolak');
    }

    public function account_list_view ()
    {
        $users = User::where('role_id',3)->where('status','!=', 'submitted')->get();
        return view('pages.account_list.index',[
            'users' => $users,
        ]);
    }
    public function profile_view ()
    {
        return view('pages.profile.index');
    }

    public function update_profile (Request $request, $userid)
    {
        $request ->validate([
            'name'=>'required|min:3',
        ]);

        $user = User::findOrFail($userid);
        $user ->name = $request->input('name');
        $user ->save();

        return back()->with('success','Profil berhasil diperbarui');
    }

    public function change_password_view ()
    {
        return view('pages.profile.change_password');
    }

    public function change_password(Request $request, $userid)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail($userid);

        // Cek password lama
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return back()->with('error', 'Gagal Mengubah password, password lama tidak sesuai');
        }

        // Ubah password baru (harus di-hash)
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return back()->with('success', 'Berhasil Mengubah password');
    }
}

