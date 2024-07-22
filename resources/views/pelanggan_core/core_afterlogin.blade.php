<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Republik Bibit</title>

    <link rel="stylesheet" href="<?= url('/') ?>/css/bootstrap.min.css">

    <link href="<?= url('/') ?>/assetss/css/style.css" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="<?= url('/') ?>/assetss/css/home_1.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="<?= url('/') ?>/assetss/css/custom.css" rel="stylesheet">

    <link href="<?= url('/') ?>/assets/plugins/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= url('/') ?>/admin/assets/fontawesome/css/all.min.css" rel="stylesheet" />

    @yield('css')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= url('/') ?>">Republik Bibit</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                <!-- ml-auto still works just fine-->
                <div class="navbar-nav ml-auto">
                    <div>
                        @if (request()->is('pelanggan/bibitborongan/checkout'))
                        <a class="btn btn-primary mx-4" href="/">Beli Eceran</a>
                        @elseif (request()->is('pelanggan/tablemonitoring'))
                        <a class="btn btn-primary mx-4" href="/">Beranda</a>
                        @elseif (request()->is('pelanggan/statustransaksi'))
                        <a class="btn btn-primary mx-4" href="/">Beranda</a>
                        @else
                        <a class="btn btn-primary mx-4"  href="/pelanggan/bibitborongan/checkout">Beli Borongan</a>
                    @endif
                    </div>
                    <div class="">
                        <a class="btn btn-secondary mr-2" href="<?= url('/') ?>/pelanggan/keranjang/">
                            <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user" aria-hidden="true"></i> <?= $nama; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="<?= url('/') ?>/pelanggan/statustransaksi">Status Transaksi</a></li>
                            <li><a class="dropdown-item" href="<?= url('/') ?>/profil">Profil</a></li>
                            <li><a class="dropdown-item" href="<?= url('/') ?>/alamat-pengiriman">Alamat Pengiriman</a></li>
                            <li><a class="dropdown-item" href="<?= url('/') ?>/pelanggan/tablemonitoring">Monitor Bibit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= url('/') ?>/logout">Logout</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    @yield('content')


    <footer class="navbar-dark bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_1">Menu</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_1">
                        <ul>
                            <li><a href="about.html">Tentang Kami</a></li>
                            <li><a href="<?= url('/') ?>/registrasi">Registrasi</a></li>
                            <li><a href="help.html">Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_2">Kategori</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_2">
                        <ul>
                            <li><a href="listing-grid-1-full.html">Melon</a></li>
                            <li><a href="listing-grid-2-full.html">Semangka</a></li>
                            <li><a href="listing-grid-1-full.html">Timun</a></li>
                            <li><a href="listing-grid-3.html">Terong</a></li>
                            <li><a href="listing-grid-1-full.html">Cabai</a></li>
                            <li><a href="listing-grid-1-full.html">Brokoli</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_3">Kontak</h3>
                    <div class="collapse dont-collapse-sm contacts" id="collapse_3">
                        <ul>
                            <li><i class="ti-home"></i>Alvia<br>Kertosono - Jawa Timur</li>
                            <li><i class="ti-headphone-alt"></i>+62 812-1614-6400</li>
                            <li><i class="ti-email"></i><a href="#0">republikbibit@alvia.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_4"></h3>
                    <div class="collapse dont-collapse-sm" id="collapse_4">
                        <div id="newsletter">
                            <div class="form-group">

                            </div>
                        </div>
                        <div class="follow_us">
                            <h5>Follow Kami</h5>
                            <ul>
                                <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                                <li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
                                <li><a href="#0"><i class="bi bi-instagram"></i></a></li>
                                <li><a href="#0"><i class="bi bi-tiktok"></i></a></li>
                                <li><a href="#0"><i class="bi bi-whatsapp"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row-->
            <hr>
            <div class="row add_bottom_25">
                <div class="col-lg-6">
                    <ul class="footer-selector clearfix">
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="additional_links">
                        <li><span>© 2024 Republik Bibit</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--/footer-->

    <!--bootstrap 5 -->
    <!-- JavaScript and dependencies -->
    <script src="<?= url('/') ?>/js/bootstrap.min.js"></script>

    <!-- COMMON SCRIPTS -->
    <script src="<?= url('/') ?>/assetss/js/common_scripts.min.js"></script>
    <script src="<?= url('/') ?>/assetss/js/main.js"></script>

    <!-- SPECIFIC SCRIPTS -->
    <script src="<?= url('/') ?>/assetss/js/carousel-home.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- SPECIFIC SCRIPTS -->
    <script  src="<?= url('/') ?>/assetss/js/carousel_with_thumbs.js"></script>
</body>

</html>
