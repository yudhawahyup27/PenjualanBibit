@extends('pegawai_core/core')

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
                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Ditambahkan</th>
                            <th>Kode Transaksi</th>
                            <th>Id User</th>
                            <th>Nama User</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Ditambahkan</th>
                            <th>Kode Transaksi</th>
                            <th>Id User</th>
                            <th>Nama User</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($tblTransaksi as $key)
                        <tr>
                            <td>{{$key->created_transaksi}}</td>
                            <td>{{$key->kode_transaksi}}</td>
                            <td>{{$key->id_user_transaksi}}</td>
                            <td>{{$key->nama_user}}</td>
                            <td>{{$key->status_name}}</td>
                            <td>
                                <a class="btn btn-primary" href="<?= url('/') ?>/pegawai/monitoringbibit/detail/{{$key->id_transaksi}}">Tambah Data Monitoring</a>
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
@endSection