<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Admin extends Controller
{
    //
    public function redirectdashboard()
    {
        return redirect()->to('/admin/data-pelanggan');
    }

    public function dataUser(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblUser = DB::table('tb_user')
    ->where('role_user', '!=', '4')
    ->get();
        $data = [
            'menu'      =>  'datauser',
            'submenu'   =>  'admin',
            'datauser'  =>  $tblUser
        ];
        return view('admin/datauser', $data);
    }

    public function add_dataUser(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $data = [
            'menu'      =>  'datauser',
            'submenu'   =>  'admin',
        ];
        return view('admin/tambah_datauser', $data);
    }

    public function create_dataUser(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        DB::table('tb_user')->insert([
            'nama_user' => $request->nama,
            'nomortelepon_user' => $request->nomortelepon,
            'alamat_user' => $request->alamat,
            'username_user' => $request->username,
            'password_user' => $request->password,
            'role_user' => $request->role,
            'status_user'   => '1',
            'created_user'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/datauser');
    }

    public function delete_dataUser(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);

        DB::table('tb_user')->where('id_user', $uri_one)->delete();
        return redirect()->to('/admin/datauser');
    }

    public function edit_dataUser(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $tblUser = DB::table('tb_user')->where('id_user', $uri_one)->first();
        $data = [
            'menu'      =>  'datauser',
            'submenu'   =>  'admin',
            'get_user'  =>  $tblUser,
        ];
        return view('admin/ubah_datauser', $data);
    }

    public function update_dataUser(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        DB::table('tb_user')->where('id_user', $uri_one)->update([
            'nama_user' => $request->nama,
            'nomortelepon_user' => $request->nomortelepon,
            'alamat_user' => $request->alamat,
            'username_user' => $request->username,
            'password_user' => $request->password,
            'role_user' => $request->role,
            'status_user'   => '1',
            'updated_user'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/datauser');
    }

    public function nonaktifkan_dataUser(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $tblUser = DB::table('tb_user')->where('id_user', $uri_one)->first();

        if ($tblUser->status_user == 1) {
            DB::table('tb_user')->where('id_user', $uri_one)->update([
                'status_user'   => '2',
                'updated_user'  => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/admin/datauser/');
        } elseif ($tblUser->status_user == 2) {
            DB::table('tb_user')->where('id_user', $uri_one)->update([
                'status_user'   => '1',
                'updated_user'  => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/admin/datauser/');
        }
    }

    public function dashboard(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblUser = DB::table('tb_user')
        ->where('role_user', '=', '4')
        ->get();
        $data = [
            'menu'      =>  'dashboard',
            'submenu'   =>  'admin',
            'datauser'  =>  $tblUser
        ];
        return view('admin/dashboard', $data);
    }

    public function MetodePembayaran(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblMetodePembayaran = DB::table('tb_metodepembayaran')->get();
        $data = [
            'menu'                  =>  'metodepembayaran',
            'submenu'               =>  'admin',
            'tblMetodePembayaran'   =>  $tblMetodePembayaran
        ];
        return view('admin/metodepembayaran', $data);
    }

    public function add_MetodePembayaran(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $data = [
            'menu'      =>  'metodepembayaran',
            'submenu'   =>  'admin',
        ];
        return view('admin/tambah_metodepembayaran', $data);
    }

    public function create_MetodePembayaran(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        DB::table('tb_metodepembayaran')->insert([
            'metodepembayaran_name' => $request->nama,
            'metodepembayaran_bank' => $request->namabank,
            'metodepembayaran_numberbank' => $request->nomorrekening,
            'metodepembayaran_created'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/metodepembayaran');
    }

    public function delete_MetodePembayaran(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);

        DB::table('tb_metodepembayaran')->where('metodepembayaran_id', $uri_one)->delete();
        return redirect()->to('/admin/metodepembayaran');
    }

}
