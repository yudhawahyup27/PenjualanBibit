@extends('pelanggan_core/core')
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
                            <h3 class="text-center font-weight-light my-4">Daftar Pelanggan Bibit</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/') ?>/registrasi" method="post">
                                {{csrf_field()}}
                                <div class="form-floating mb-3">
                                    <label for="inputNama">Nama Lengkap</label>
                                    <input class="form-control" id="inputNama" type="text" name="nama" placeholder="Isikan Nama Lengkap" />
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="inputAlamat">Alamat</label>
                                    <input class="form-control" id="inputAlamat" type="text" name="alamat" placeholder="Isikan Alamat" />
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="inputNama">Nomor Telepon</label>
                                    <input class="form-control" id="inputNomorTelepon" type="number" name="nomortelepon" placeholder="Isikan Nomor Telepon" />
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="inputUsername">Username</label>
                                            <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Isikan Username" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="inputPassword">Password</label>
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block" href="login.html">Daftar Sekarang</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <div class="small"><a href="/login">Sudah punya akun? Pergi ke login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/carousel-->

</main>
@endSection
