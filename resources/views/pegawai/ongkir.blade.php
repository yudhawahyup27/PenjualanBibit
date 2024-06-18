@extends('pegawai_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Ongkos Kirim</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Ongkos Kirim</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Data Ongkos Kirim
        </div>
        <div class="card-body">
            <a class="btn btn-primary" href="<?= url('/') ?>/pegawai/ongkir/tambah"><i class="fa-solid fa-plus"></i> Tambah Data</a>
            <div class="table-responsive">
                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dikirim Dari</th>
                            <th>Dikirim Ke</th>
                            <th>Price</th>
                            <th>Updated</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Dikirim Dari</th>
                            <th>Dikirim Ke</th>
                            <th>Price</th>
                            <th>Updated</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($dataongkir as $key)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>Kertosono</td>
                            <td>{{$key->kecamatan_name}}</td>
                            <td>Rp {{$key->ongkir}}</td>
                            <td>{{$key->kecamatan_updated}}</td>
                            <td>
                                <a href="<?= url('/') ?>/pegawai/ongkir/ubah/{{$key->kecamatan_id}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="<?= url('/') ?>/pegawai/ongkir/hapus/{{$key->kecamatan_id}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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
