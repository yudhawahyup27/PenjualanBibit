@extends('pegawai_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Ongkos Kirim</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/pegawai/ongkir">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/pegawai/ongkir">Ongkos Kirim</a></li>
        <li class="breadcrumb-item active">Ubah Ongkos Kirim</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Ubah Data Ongkos Kirim
        </div>
        <div class="card-body">
            <form method="post" action="<?= url('/') ?>/pegawai/ongkir/ubah/{{$dataongkir->kecamatan_id}}">
                {{@csrf_field()}}
                <div class="mb-3">
                    <label>Dikirim Dari</label>
                    <input class="form-control" type="text" name="dari" value="kerosono" placeholder="Isikan Dikirim Dari" required disabled />
                </div>
                <div class="mb-3">
                    <label>Dikirim Ke</label>
                    <input class="form-control" type="text" name="ke" value="{{$dataongkir->kecamatan_name}}" placeholder="Isikan Dikirim Ke" required />
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input class="form-control" type="text" name="harga" value="{{$dataongkir->ongkir}}" placeholder="Isikan Harga" required />
                </div>
                <div class="form-floating mb-3">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-plus"></i> Ubah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

@endSection
