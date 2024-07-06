@extends('admin_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/data-pelanggan">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/admin/datauser">Data User</a></li>
        <li class="breadcrumb-item active">Tambah Data User</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Tambah Data User
        </div>
        <div class="card-body">
            <form method="post" action="<?= url('/') ?>/admin/datauser/ubah/{{$get_user->id_user}}">
                {{@csrf_field()}}
                <div class="mb-3">
                    <label for="inputNama">Nama Lengkap</label>
                    <input class="form-control" id="inputNama" type="text" name="nama" placeholder="Isikan Nama Lengkap" value="{{$get_user->nama_user}}" required />
                </div>
                <div class="mb-3">
                    <label for="inputAlamat">Alamat</label>
                    <input class="form-control" id="inputAlamat" type="text" name="alamat" placeholder="Isikan Alamat" value="{{$get_user->alamat_user}}" required />
                </div>
                <div class="mb-3">
                    <label for="inputNama">Nomor Telepon</label>
                    <input class="form-control" id="inputNomorTelepon" type="text" name="nomortelepon" placeholder="Isikan Nomor Telepon" value="{{$get_user->nomortelepon_user}}" required />
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3 mb-md-0">
                            <label for="inputUsername">Username</label>
                            <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Isikan Username" value="{{$get_user->username_user}}" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 mb-md-0">
                            <label for="inputPassword">Password</label>
                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Isikan Password" value="{{$get_user->password_user}}" required />
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputNama">Role</label>
                    <select name="role" class="form-select" required>
                        <option selected disabled>- Pilih Role Akun -</option>
                        <option value="1" <?php if ($get_user->role_user == 1) {
                                                echo 'selected';
                                            } ?>>Admin</option>
                        <option value="2" <?php if ($get_user->role_user == 2) {
                                                echo 'selected';
                                            } ?>>Pegawai</option>
                        <option value="3" <?php if ($get_user->role_user == 3) {
                                                echo 'selected';
                                            } ?>>Pemilik</option>
                    </select>
                </div>
                <div class="form-floating mb-3">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-pen-to-square"></i> Edit Data</button>
                    {{-- @if($get_user->status_user == 1)
                    <a class="btn btn-warning" href="<?= url('/') ?>/admin/datauser/ubah-status/{{$get_user->id_user}}"><i class="fa-solid fa-user-slash"></i> NonAktifkan</a>
                    @elseif($get_user->status_user == 2)
                    <a class="btn btn-warning" href="<?= url('/') ?>/admin/datauser/ubah-status/{{$get_user->id_user}}"><i class="fa-solid fa-user"></i> Aktifkan</a>
                    @endif --}}
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

@endSection
