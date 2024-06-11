@extends('admin_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Metode Pembayaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Metode Pembayaran</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Metode Pembayaran
        </div>
        <div class="card-body">
            <a class="btn btn-primary" href="<?= url('/') ?>/admin/metodepembayaran/tambah"><i class="fa-solid fa-plus"></i> Tambah Data</a>
            <div class="table-responsive">            
                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Rekening</th>
                            <th>Nama Bank</th>
                            <th>Nomor Rekening</th>
                            <th>Dibuat</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Rekening</th>
                            <th>Nama Bank</th>
                            <th>Nomor Rekening</th>
                            <th>Dibuat</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($tblMetodePembayaran as $key)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$key->metodepembayaran_name}}</td>
                            <td>{{$key->metodepembayaran_bank}}</td>
                            <td>{{$key->metodepembayaran_numberbank}}</td>
                            <td>{{$key->metodepembayaran_created}}</td>
                            <td>
                                <a href="<?= url('/') ?>/admin/metodepembayaran/hapus/{{$key->metodepembayaran_id}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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