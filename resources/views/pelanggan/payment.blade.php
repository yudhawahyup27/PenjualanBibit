@extends('pelanggan_core/core_afterlogin')
@section('css')
<!-- SPECIFIC CSS -->
<link href="css/product_page.css" rel="stylesheet">
<!-- YOUR CUSTOM CSS -->
<link href="css/custom.css" rel="stylesheet">

@endSection
@section('content')
<div class="container">

    <div class="row mt-2 mb-5">
        <div class="col-md-12">
            <div class="text-center">
                <h3>Check Out</h3>
            </div>
            <div>
                <h5>Detail Pesanan</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Harga</td>
                            <td>Satuan</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="<?= url('/') ?>/images/noimage.png" width="30%"></td>
                            <td><?= $produk->nama_bibit ?></td>
                            <td><?= $produk->harga_bibit ?></td>
                            <td><?= $produk->harga_bibit ?></td>
                            <td><?= $produk->harga_bibit ?></td>
                        </tr>
                    </tbody>
                </table>
                <div><a href="<?= url('/') ?>/pelanggan/pembayaran/<?= $produk->id_produk ?>" class="btn_1">Buat Pesanan</a></div>
            </div>
        </div>
        <!-- /prod_info -->
    </div>
</div>
@endSection