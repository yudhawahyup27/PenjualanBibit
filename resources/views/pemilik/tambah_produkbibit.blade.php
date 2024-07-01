@extends('pemilik_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Produk Bibit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/pemilik/bibit">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/pemilik/bibit">Produk Bibit</a></li>
        <li class="breadcrumb-item active">Tambah Produk Bibit</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Tambah Data Produk Bibit
        </div>
        <div class="card-body">
            <form method="post" action="<?= url('/') ?>/pemilik/bibit/tambah"  enctype="multipart/form-data">
                {{@csrf_field()}}
                <div class="mb-3">
                    <label>Nama Bibit</label>
                    <input class="form-control" type="text" name="nama" placeholder="Isikan Nama Bibit" required />
                </div>
                <div class="mb-3">
                    <label>Detail</label>
                    <textarea class="form-control" type="text" name="detail" placeholder="Isikan Detail Bibit" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input class="form-control" type="text" name="harga" placeholder="Isikan Harga Bibit" required />
                </div>
                <div class="mb-3">
                    <label>Stok</label>
                    <input class="form-control" type="text" name="stok" placeholder="Isikan Stok Bibit" required />
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input class="form-control" name="image1" type="file" id="formFile">
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
