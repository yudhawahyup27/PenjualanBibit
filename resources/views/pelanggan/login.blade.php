@extends('pelanggan_core/core')
@section('css')

@endSection
@section('content')
<main>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Login Pelanggan Bibit</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Masukkan Username dan Password Disini</h5>
                        </div>
                        @if(session('status'))
                        <div class="alert alert-danger">
                            <b>Opps!</b> {{session('status')}}
                        </div>
                        @endif
                        <form method="post" action="<?= url('/') ?>/login">
                        {{@csrf_field()}}
                            <div class="form-floating mb-3">
                                <label for="inputEmail">Username</label>
                                <input class="form-control" id="inputEmail" name="username" type="text" placeholder="Masukkan Username" />
                            </div>
                            <div class="form-floating mb-3">
                                <label for="inputPassword">Password</label>
                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Masukkan Password" />
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small" href=""></a>
                                <button class="btn btn-primary" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="<?= url('') ?>/registrasi">Daftar Sebagai Pelanggan!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endSection