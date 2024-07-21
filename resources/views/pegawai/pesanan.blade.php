@extends('pegawai_core.core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pesanan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Pesanan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Data Pesanan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Pembelian Pesanan</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Produk</th>
                            <th>QTY Beli</th>
                            <th>Nama User</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>Beban</th>
                            <th>Kurir</th>
                            <th>Detail Rumah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Pembelian Pesanan</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Produk</th>
                            <th>QTY Beli</th>
                            <th>Nama User</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>Beban</th>
                            <th>Kurir</th>
                            <th>Detail Rumah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($pesen as $key)
                        <tr>
                            <td>{{ $key->created_transaksi }}</td>
                            <td>{{ $key->kode_transaksi }}</td>
                            <td>{{ $key->nama_bibit }}</td>
                            <td>{{ $key->Qty_beli }}</td>
                            <td>{{ $key->nama_user }}</td>
                            <td>{{ $key->city_name }}</td>
                            <td>{{ $key->province_name }}</td>
                            <td>{{ $key->beban }}</td>
                            <td>{{ $key->kurir }}</td>
                            <td>{{ $key->detail_rumah }}</td>
                            <td>Rp {{ number_format((float)$key->total_transaksi, 0, ',', '.') }}</td>
                            <td>
                                @if($key->status_transaksi == 1)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahproses/{{ $key->id_transaksi }}">Sedang Di Proses</a>
                                @elseif ($key->status_transaksi == 2)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahdikirim/{{ $key->id_transaksi }}">Sedang Di Kirim</a>
                                @elseif($key->status_transaksi == 3)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahditerima/{{ $key->id_transaksi }}">Sedang Diterima</a>
                                @elseif($key->status_transaksi == 4)
                                Sudah Diterima
                                @endif
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
                [0, "desc"]
            ]
        });
    });
</script>
@endsection
