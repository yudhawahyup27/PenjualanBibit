@extends('admin_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Data pelanggan</a></li>
        <li class="breadcrumb-item active">Data Pelanggan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Data Pelanggan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Role</th>
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
