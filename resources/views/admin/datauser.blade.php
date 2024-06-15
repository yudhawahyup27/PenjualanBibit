@extends('admin_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Data User</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Data User
        </div>
        <div class="card-body">
            <a class="btn btn-primary" href="<?= url('/') ?>/admin/datauser/tambah"><i class="fa-solid fa-plus"></i> Tambah Data</a>
            <div class="table-responsive">
                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Role</th>

                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Role</th>

                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($datauser as $key)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$key->nama_user}}</td>
                            <td>{{$key->nomortelepon_user}}</td>
                            <td>{{$key->alamat_user}}</td>
                            <td>
                                @if($key->role_user == 1)
                                Admin
                                @elseif($key->role_user == 2)
                                Pegawai
                                @elseif($key->role_user == 3)
                                Pemilik
                                @else
                                Pelanggan
                                @endif
                            </td>

                            <td>
                                <a href="<?= url('/') ?>/admin/datauser/ubah/{{$key->id_user}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="<?= url('/') ?>/admin/datauser/hapus/{{$key->id_user}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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
