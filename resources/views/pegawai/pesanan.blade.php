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
                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Ditambahkan</th>
                            <th>Kode Transaksi</th>
                            <th>Id User</th>
                            <th>Nama User</th>
                            <th>Total</th>
                            {{-- <th>Bukti Transfer</th> --}}
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Ditambahkan</th>
                            <th>Kode Transaksi</th>
                            <th>Id User</th>
                            <th>Nama User</th>
                            <th>Total</th>
                            <th>Aksi</th>
                            {{-- <th>#</th> --}}
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($pesen as $key)
                        <tr>
                            <td>{{ $key->created_transaksi }}</td>
                            <td>{{ $key->kode_transaksi }}</td>
                            <td>{{ $key->id_user_transaksi }}</td>
                            <td>{{ $key->nama_user }}</td>
                            <td>Rp {{ number_format((float)$key->total_transaksi, 0, ',', '.') }}</td>
                            {{-- @if ($key->bukti_transfer)
                            <td><img src="{{ asset('/storage/' . $key->bukti_transfer) }}" alt="Bukti Transfer" width="100"></td>

                                    @else
                                    <td>bukti transferan tidak ada data</td>

                            @endif --}}


                            <td>
                                {{-- @if($key->status_transaksi == 1)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahbayar/{{ $key->id_transaksi }}">Sudah Bayar</a> --}}
                                @if($key->status_transaksi == 1)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahproses/{{ $key->id_transaksi }}">Sudah Dikirim</a>

                                @elseif ($key->status_transaksi == 2)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahdikirim/{{ $key->id_transaksi }}">Sudah Di Proses</a>

                                @elseif($key->status_transaksi == 3)
                                <a class="btn btn-primary" href="{{ url('/') }}/pegawai/pesanan/sudahditerima/{{ $key->id_transaksi }}">Sudah Diterima</a>
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
@endSection
