@extends('pelanggan_core/core_afterlogin')
@section('css')

@endSection
@section('content')
<main style="margin-bottom: 20.6px;">
    <div id="carousel-home">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Ubah Profil Pelanggan Republik Bibit</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/') ?>/profil" method="post">
                                {{csrf_field()}}
                                <div class="form-floating mb-3">
                                    <label for="inputNama">Nama Lengkap</label>
                                    <input class="form-control" id="inputNama" type="text" name="nama" value="{{$get_user->nama_user}}" />
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="inputAlamat">Alamat</label>
                                    <input class="form-control" id="inputAlamat" type="text" name="alamat" value="{{$get_user->alamat_user}}" />
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="inputNama">Nomor Telepon</label>
                                    <input class="form-control" id="inputNomorTelepon" type="text" name="nomortelepon" value="{{$get_user->nomortelepon_user}}" />
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="inputUsername">Username</label>
                                            <input class="form-control" id="inputUsername" type="text" placeholder="{{$get_user->username_user}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="inputPassword">Password</label>
                                            <input class="form-control" id="inputPassword" name="password" type="password" value="{{$get_user->password_user}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block" href="login.html">Ubah Akun</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/carousel-->

</main>
@endSection