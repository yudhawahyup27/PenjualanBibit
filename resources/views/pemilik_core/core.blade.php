<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Republik Bibit adalah platform mempermudah pembelian bibit yang berkualitas sehingga dapat menghasilkan panen yang berlimpah" />
        <meta name="author" content="Republik Bibit" />
        <title>Pemilik Republik Bibit</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= url('/') ?>/admin/css/styles.css" rel="stylesheet" />
        <link href="<?= url('/') ?>/admin/assets/fontawesome/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="<?= url('/') ?>">Republik Bibit</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> -->
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Pengaturan</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="<?= url('/') ?>/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Pemilik</div>
                            <a class="nav-link <?php if($menu == 'dashboard2'){ echo 'active'; } ?>" href="<?= url('/') ?>/pemilik/dashboard22">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-gauge"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link <?php if($menu == 'stokbibit2'){ echo 'active'; } ?>" href="<?= url('/') ?>/pemilik/stokbibit2">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-packing"></i></i></div>
                                Stok
                            </a>
                            <a class="nav-link <?php if($menu == 'terlaris'){ echo 'active'; } ?>" href="<?= url('/') ?>/terlaris">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-packing"></i></i></div>
                                Terlaris
                            </a>
                            <a class="nav-link <?php if($menu == 'bibit2'){ echo 'active'; } ?>" href="<?= url('/') ?>/pemilik/produkbibit">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-packing"></i></i></div>
                                Bibit
                            </a>
                            <a class="nav-link <?php if($menu == 'laporanpenjualan'){ echo 'active'; } ?>" href="<?= url('/') ?>/pemilik/laporanpenjualan">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-column"></i></div>
                                Laporan Penjualan
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Republik Bibit 2024</div>
                            <div>
                                <a href="#"></a>
                                &middot;
                                <a href="#"></a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.4/js/dataTables.min.js"></script>
        <script src="<?= url('/') ?>/admin/js/scripts.js"></script>
        @yield('js')
    </body>
</html>
