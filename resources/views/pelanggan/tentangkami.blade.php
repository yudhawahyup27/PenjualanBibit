@extends('pelanggan_core/core')

@section('css')
<!-- BASE CSS -->
<link href="<?= url('/') ?>/assetss/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= url('/') ?>/assetss/css/style.css" rel="stylesheet">

<!-- SPECIFIC CSS -->
<link href="<?= url('/') ?>/assetss/css/about.css" rel="stylesheet">

<!-- YOUR CUSTOM CSS -->
<link href="<?= url('/') ?>/assetss/css/custom.css" rel="stylesheet">
@endSection

@section('content')
<main class="bg_gray">
    <div class="container margin_60_35 add_bottom_30">
        <div class="main_title">
            <h2>Tentang Kami</h2>
            <p>Republik Bibit adalah tempat pemesanan dan pembelian berbagai bibit tanaman holtikultura. Penyemaian bibit tanaman di pembibitan Republik Bibit ini dilakukan dengan teknik tertentu agar menghasilkan bibit tanaman yang berkualitas dan siap tanam di lahan yang luas.</p>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="box_about">
                    <h2>Produk Unggulan Kami</h2>
                    <p class="lead">Semua bibit yang kami jual merupakan produk unggulan dan pasti dapat dipanen dengan kualitas yang baik.</p>
                    <a class="btn btn-primary" href="<?= url('/') ?>">Beli Sekarang</a>
                    <p></p>
                    <!-- <img src="<?= url('/') ?>/assetss/img/arrow_about.png" alt="" class="arrow_1"> -->
                </div>
            </div>
            <div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
                <img src="<?= url('/') ?>/images/about.jpeg" style=" transform: rotate(-90deg);" alt="" class="img-fluid" width="350" height="268">
            </div>
        </div>
    </div>
    <!-- /container -->

    <div class="bg_white">
        <div class="container margin_60_35">
            <div class="main_title">
                <h2>Kenapa Memilih</h2>
                <p>Republik Bibit?</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="box_feat">
                        <i class="ti-medall-alt"></i>
                        <h3>+ 1000 Customers</h3>
                        <p>Kami memiliki lebih dari 1000 customers diseluruh Indonesia.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="box_feat">
                        <i class="ti-help-alt"></i>
                        <h3>24Jam Chat</h3>
                        <p>Pelayanan yang terbaik adalah tujuan kami. Maka untuk pertanyaan via Whatsapp bisa 24 Jam. </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="box_feat">
                        <i class="ti-gift"></i>
                        <h3>Penawaran Terbaik</h3>
                        <p>Produk kami memiliki harga yang ramah dikantong dan selalu mendapatkan diskon terbaik.</p>
                    </div>
                </div>
            </div>
            <!--/row-->
        </div>
    </div>
</main>

@endSection
