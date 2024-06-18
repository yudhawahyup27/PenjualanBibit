@extends('pemilik_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Produk Bibit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Produk Bibit</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            List Data Produk Bibit
        </div>
        <div class="card-body">

            <div class="table-responsive">
            <table class="table table-striped table-bordered dataTable display" id="datatablesSimple" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode </th>
                            <th>Nama Bibit</th>
                            <th>Detail </th>
                            <th>Harga </th>
                            <th>Gambar </th>
                            <th>Terjual </th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kode </th>
                            <th>Nama Bibit</th>
                            <th>Detail </th>
                            <th>Harga </th>
                            <th>Gambar </th>
                            <th>Terjual </th>


                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($dataproduk as $key)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$key->kode_bibit}}</td>
                            <td>{{$key->nama_bibit}}</td>
                            <td>{{$key->detail_bibit}}</td>
                            <td>
                                Rp <?= number_format((float)$key->harga_bibit, 0, ',', '.') ?>
                            </td>
                            <td><img width="20%" src="<?= url('/') ?>/images/<?= $key->gambar_bibit ?>" alt=""></td>
                            <td>
                                @if($key->terjual_bibit == 0)
                                0
                                @else
                                {{ $key->terjual_bibit }}
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
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable({
            "order": [
                [0, "asc"]
            ],
        });
    });
</script>
@endSection
