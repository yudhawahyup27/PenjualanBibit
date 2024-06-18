


@extends('pegawai_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Monitoring Bibit Transaksi </h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Monitoring Bibit</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Data Monitoring Bibit
        </div>
        <div class="card-body">

            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            List Data Monitoring Bibit
        </div>
        <div class="card-body">

                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Tanggal</th>
                            <th>Umur</th>
                            <th>Tinggi</th>
                            <th>Keterangan</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Gambar</th>
                            <th>Tanggal</th>
                            <th>Umur</th>
                            <th>Tinggi</th>
                            <th>Keterangan</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <tr>
                            <td style="width: 10%;"><img width="100%" src="<?= url('/') ?>/images/<?= ?>" alt=""></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a class="btn btn-danger" href="<?= url('/') ?>/pegawai/monitoringbibit/hapus/<?=  ?>"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

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
                [1, "desc"]
            ]
        });
    });
</script>
@endSection

