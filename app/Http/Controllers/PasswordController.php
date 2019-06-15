<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class PasswordController extends Controller
{
    public function index()
    {
      $judul      = 'Hijrah Mandiri - Ganti Password';
      $page       = 'user';

      return view('change-password', [  'page'        => $page,
                                        'judul'       => $judul
                            ]);
    }

    public function SimpanPassword(Request $request)
    {
      request()->validate([
        'password_lama'         => 'required|different:password_baru|min:5',
        'password_baru'         => 'required|different:password_lama|min:5',
        'setuju_ganti_password' => 'required'
      ],
      [
          'password_baru.required'          => ' Anda harus memasukkan password baru!',
          'password_lama.required'          => ' Anda harus memassukan password lama!',
          'setuju_ganti_password.required'  => ' Anda belum menyetujui form!',
          'password_baru.different'         => ' Password baru harus berbeda !'
      ]);

      $user = Auth::user();
      $old_pas = $request['password_lama'];
      if (Hash::check($old_pas, Auth::user()->password)) {
        $data = [
          'password' => Hash::make($request['password_baru'])
        ];
        DB::table('users')->where('id', Auth::user()->id)->update($data);
        return redirect('/')->with('message', 'Password berhasil diganti.');
      }
      else {
        return redirect()->back()->with('error', 'Password lama yang anda masukkan salah!');
      }

    }
}
