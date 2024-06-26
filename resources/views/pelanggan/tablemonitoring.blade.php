@extends('pelanggan_core.core_afterlogin')

@section('css')
<!-- SPECIFIC CSS -->
<link href="css/product_page.css" rel="stylesheet">
<!-- YOUR CUSTOM CSS -->
<link href="css/custom.css" rel="stylesheet">
@endsection

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
                            <th>Nama Bibit</th>
                            <th>Kuantitas Bibit</th>
                            <th>Detail Monitoring</th>
                            <th>Status</th>
                            <th>Struk</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Bibit</th>
                            <th>Kuantitas bibit</th>
                            <th>Detail Monitoring</th>
                            <th>Status</th>
                            <th>Struk</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($tblTransaksi as $key)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $key->kode_transaksi }}</td>
                            <td>{{ $key->name }}</td>
                            <td>{{ $key->kuantitas_bibit }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('pelanggan.monitorbibit', ['id' => $key->kode_transaksi]) }}">Lihat Data Monitoring</a>
                            </td>
                            <td>{{ $key->status_name }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ route('pelanggan.downloadStrukborongan', ['id' => $key->kode_transaksi]) }}">Download Struk</a>
                            </td>
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
@endsection
