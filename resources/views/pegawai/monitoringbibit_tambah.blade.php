@extends('pegawai_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Monitoring Bibit Transaksi {{$tblTransaksi->kode_transaksi}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/pegawai/bibit">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/pegawai/bibit">Monitoring Bibit Transaksi {{$tblTransaksi->kode_transaksi}}</a></li>
        <li class="breadcrumb-item active">Tambah Monitoring Bibit Transaksi {{$tblTransaksi->kode_transaksi}}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Tambah Data Monitoring Bibit Transaksi {{$tblTransaksi->kode_transaksi}}
        </div>
        <div class="card-body">
            <form method="post" action="<?= url('/') ?>/pegawai/monitoringbibit/detail/{{$tblTransaksi->id_transaksi}}/tambah"  enctype="multipart/form-data">
                {{@csrf_field()}}
                <div class="mb-3">
                    <label>Umur</label>
                    <input class="form-control" type="number" name="umur" placeholder="Isikan Umur" required />
                </div>
                <div class="mb-3">
                    <label>Tinggi</label>
                    <input class="form-control" type="text" name="tinggi" placeholder="Isikan Keterangan Bibit" required />
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea class="form-control" type="text" name="keterangan" placeholder="Isikan Tinggi Bibit" required></textarea>
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
