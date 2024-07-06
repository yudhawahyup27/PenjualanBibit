@extends('pegawai_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Produk Bibit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/pegawai/produkbibit">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/pegawai/produkbibit">Produk Bibit</a></li>
        <li class="breadcrumb-item active">Tambah Produk Bibit</li>
    </ol>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            Tambah Data Produk Bibit
        </div>
        <div class="card-body">
            <form method="post" action="{{ url('/pegawai/produkbibit/tambah') }}" enctype="multipart/form-data">
                @csrf
                <div hidden class="mb-3">
                    <label>Nama User</label>
                    <select hidden name="user" class="form-select">
                        <option selected disabled>--- Pilih User ---</option>
                        @foreach($getuserpemilik as $key)
                        <option value="{{$key->id_user}}">{{$key->nama_user}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Nama Bibit</label>
                    <input class="form-control" type="text" name="nama" placeholder="Isikan Nama Bibit" value="{{ old('nama') }}" required />
                </div>
                <div class="mb-3">
                    <label>Detail</label>
                    <textarea class="form-control" type="text" name="detail" placeholder="Isikan Detail Bibit" required>{{ old('detail') }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input class="form-control" type="text" name="harga" placeholder="Isikan Harga Bibit" value="{{ old('harga') }}" required />
                </div>
                <div class="mb-3">
                    <label>Harga Borongan</label>
                    <input class="form-control" type="text" name="harga_borongan" placeholder="Isikan Harga Bibit borongan" value="{{ old('harga_borongan') }}" required />
                </div>
                <div class="mb-3">
                    <label>Stok</label>
                    <input class="form-control" type="text" name="stok" placeholder="Isikan Stok Bibit" value="{{ old('stok') }}" required />
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
