@extends('pemilik_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Produk Bibit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Produk Bibit</li>
    </ol>
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
                            <th>Kode Barang</th>
                            <!-- <th>Nama Bibit</th> -->
                            <th>Stok </th>
                            <th>Diupdate</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Stok </th>
                            <th>Diupdate</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($dataproduk as $key)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$key->stok_kode_barang}}</td>
                            <td>{{$key->stok_jumlah}}</td>
                            <td>{{$key->updated_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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