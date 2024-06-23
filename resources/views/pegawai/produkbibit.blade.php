@extends('pegawai_core/core')

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
            <a class="btn btn-primary" href="<?= url('/') ?>/pegawai/produkbibit/tambah"><i class="fa-solid fa-plus"></i> Tambah Data</a>
            <div class="table-responsive">
                <table class="table table-responsive" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>

                            <th>Kode </th>
                            <th>Nama Bibit</th>
                            <th>Detail </th>
                            <th>Harga </th>
                            <th>Stok </th>
                            <th>Gambar </th>
                            <th>Terjual </th>
                            <th>Status </th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>

                            <th>Kode </th>
                            <th>Nama Bibit</th>
                            <th>Detail </th>
                            <th>Harga </th>
                            <th>Stok </th>
                            <th>Gambar </th>
                            <th>Terjual </th>
                            <th>Harga Boronga </th>
                            <th>#</th>
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

                                <?= number_format((float)$key->harga_bibit, 0, ',', '.') ?>
                            </td>
                            <td>{{$key->stok_bibit}}</td>
                            <td><img width="100" src="<?= url('/') ?>/images/<?= $key->gambar_bibit ?>" alt=""></td>
                            <td>
                                @if($key->terjual_bibit == 0)
                                0
                                @else
                                {{ $key->terjual_bibit }}
                                @endif
                            </td>
                            <td>
                                <?= number_format((float)$key->harga_borong, 0, ',', '.') ?>
                            </td>
                            <td>
                                <a href="<?= url('/') ?>/pegawai/produkbibit/ubah/{{$key->id_produk}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="<?= url('/') ?>/pegawai/produkbibit/hapus/{{$key->id_produk}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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
