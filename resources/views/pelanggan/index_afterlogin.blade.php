@extends('pelanggan_core/core_afterlogin')
@section('css')

@endSection
@section('content')
<main>
    <div id="carousel-home">
        <div class="container margin_60_35">
            <div class="main_title">
                <h2>Bibit Terlaris</h2>
                <span>Bibit</span>
                <p>Bibit Terlaris dan Kualitas Terbaik</p>
            </div>
            <div class="row small-gutters">
                @foreach($produk as $key)
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="grid_item">
                        <figure>
                            <!-- <span class="ribbon off">-30%</span> -->
                            <a href="/pelanggan/detail/<?= $key->id_produk ?>">
                                <?php
                                if($key->gambar_bibit == ''){
                                    $images = 'images/noimage.png';
                                }else {
                                    $images =  $key->gambar_bibit;
                                }
                                ?>
                                <img class="img-fluid lazy loaded" src="<?= url('/') ?>/images/<?= $images ?>" data-src="<?= url('/') ?>/images/<?= $images ?>" alt="" data-was-processed="true">
                                <img class="img-fluid lazy loaded" src="<?= url('/') ?>/images/<?= $images ?>" data-src="<?= url('/') ?>/images/<?= $images ?>" alt="" data-was-processed="true">
                            </a>
                            <!-- <div data-countdown="2024/04/10" class="countdown">00D 00:00:00</div> -->
                        </figure>
                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i></div>
                        <a href="/pelanggan/detail/<?= $key->id_produk ?>">
                            <h3><?= $key->nama_bibit ?></h3>
                        </a>
                        <div class="price_box">
                            <span class="new_price">Rp <?= number_format((float)$key->harga_bibit, 0,',','.'); ?></span>
                            <!-- <span class="old_price">Rp 120.000</span> -->
                        </div>
                        <ul>
                        </ul>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /col -->
                @endforeach
            </div>
            <!-- /row -->
        </div>
        <div id="icon_drag_mobile"></div>
    </div>
    <!--/carousel-->
</main>
@endSection
