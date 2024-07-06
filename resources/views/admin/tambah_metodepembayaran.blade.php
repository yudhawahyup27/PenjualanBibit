@extends('admin_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Metode Pembayaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/data-pelanggan">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/admin/datauser">Metode Pembayaran</a></li>
        <li class="breadcrumb-item active">Tambah Metode Pembayaran</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Tambah Metode Pembayaran
        </div>
        <div class="card-body">
            <form method="post" action="<?= url('/') ?>/admin/metodepembayaran/tambah">
                {{@csrf_field()}}
                <div class="mb-3">
                    <label for="inputNama">Nama Lengkap</label>
                    <input class="form-control" id="inputNama" type="text" name="nama" placeholder="Isikan Nama Lengkap" required />
                </div>
                <div class="mb-3">
                    <label for="inputAlamat">Nama Bank</label>
                    <input class="form-control" id="inputAlamat" type="text" name="namabank" placeholder="Isikan Nama Bank" required />
                </div>
                <div class="mb-3">
                    <label for="inputNama">Nomor Rekening</label>
                    <input class="form-control" id="inputNomorTelepon" type="text" name="nomorrekening" placeholder="Isikan Nomor Rekening" required />
                </div>
                <div class="form-floating mb-3">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-plus"></i> Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

@endSection
