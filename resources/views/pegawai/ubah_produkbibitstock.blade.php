@extends('pegawai_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Produk Bibit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/pegawai/produkbibit">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/pegawai/produkbibit">Produk Bibit</a></li>
        <li class="breadcrumb-item active">Ubah Produk Bibit</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Ubah Data Stock Bibit
        </div>
        <div class="card-body">
            <form method="post" action="{{ url('/pegawai/produkbibit/ubah/stock/' . $get_produk->id_produk) }}" enctype="multipart/form-data">
                @csrf
                <div hidden class="mb-3">
                    <label>Nama User</label>
                    <select hidden name="user" class="form-select">
                        <option selected disabled>--- Pilih User ---</option>
                        @foreach($getuserpemilik as $key)
                        <option value="{{ $key->id_user }}">{{ $key->nama_user }}</option>
                        @endforeach
                    </select>
                </div>
                <div hidden class="mb-3">
                    <label>Nama Bibit</label>
                    <input class="form-control" type="text" name="nama" placeholder="Isikan Nama Bibit" value="{{ $get_produk->nama_bibit }}" required />
                </div>
                <div class="mb-3">
                    <label>Stok Bibit</label>
                    <input class="form-control" type="number" name="stok" placeholder="Isikan Stok Bibit" value="{{ $get_produk->stok_bibit }}" required />
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
