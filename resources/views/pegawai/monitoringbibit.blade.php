@extends('pegawai_core.core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Monitoring Bibit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Monitoring Bibit</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Data Monitoring Bibit
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Qty Pembelian</th>
                            <th>Nama Pelanggan</th>
                            <th>Nama Bibit</th>
                            <th>Kota dan Kabupaten</th>
                            <th>provinsi</th>
                            <th>Alamat Pengiriman</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Qty Pembelian</th>
                            <th>Nama Pelanggan</th>
                            <th>Nama Bibit</th>
                            <th>Kota dan Kabupaten</th>
                            <th>provinsi</th>
                            <th>Alamat Pengiriman</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($tblTransaksi as $key)
                        <tr>
                            <td>{{ $key->kode_transaksi }}</td>
                            <td>{{ $key->kuantitas_bibit }}</td>
                            <td>{{ $key->nama_user }}</td>
                            <td>{{ $key->nama_bibit }}</td>

                            <td>{{ $key->city_name }}</td>
                            <td>{{ $key->province_name }}</td>
                            <td>{{ $key->detail_rumah }}</td>
                            <td>{{ $key->status_name }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('pegawai.monitoringbibit.detail', ['id' => $key->kode_transaksi]) }}">Tambah Data Monitoring</a>
                                @if($key->status_transaksi == 1)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahprosesborong/{{ $key->id }}">Sedang Proses</a>
                                @elseif ($key->status_transaksi == 2)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahdikirimborong/{{ $key->id }}">Sedang Dikirim</a>
                                @elseif($key->status_transaksi == 3)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahditerimaborong/{{ $key->id }}">Sedang Diterima</a>
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
