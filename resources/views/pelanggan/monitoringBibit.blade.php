@extends('pelanggan_core.core_afterlogin')

@section('css')
<!-- SPECIFIC CSS -->
<link href="css/product_page.css" rel="stylesheet">
<!-- YOUR CUSTOM CSS -->
<link href="css/custom.css" rel="stylesheet">
@endSection

@section('content')
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<div class="row">
    <div class="col mx-4"><img src="{{ asset('images/' . $produk->gambar_bibit) }}" width="200" alt="" srcset=""></div>
    <div class="col">
        <h1>{{ $produk->nama_bibit }}</h1>
        <p>Tanggal semai: {{ date('j \\ F Y', strtotime( $transaksi->created_at ))}}</p>
        <p>Tanggal tanam: {{ date('j \\ F Y', strtotime( $transaksi->tanggal_tanam ))}} </p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        List Data Stok Bibit
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-responsive" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Tanggal</th>
                        <th>Umur</th>
                        <th>Tinggi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Tanggal</th>
                        <th>Umur</th>
                        <th>Tinggi</th>
                        <th>Keterangan</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($monitor as $key)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        {{-- <td><img src="{{ asset('image/' . $key->perkembangan_gambar) }}" alt="Gambar" width="50"></td> --}}

                        <td><a href="{{ $key->perkembangan_link }}">Link Video</a></td>
                        <td>{{ $key->perkembangan_tanggal }}</td>
                        <td>{{ $key->perkembangan_umur }} Hari</td>
                        <td>{{ $key->perkembangan_tinggi }} Cm</td>
                        <td>{{ $key->perkembangan_deskripsi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable({
            "order": [
                [0, "asc"]
            ]
        });
    });
</script>
@endSection
