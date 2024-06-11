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
                <h3>Keranjang Belanja</h3>
            </div>
            <div>
                <h5>Detail Pesanan</h5>
                @if($countCart == 0)
                <?php return redirect('/pengguna/keranjang') ?>
                <div><a href="<?= url('/') ?>" class="btn_1">Beli Produk Sekarang</a></div>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Gambar</td>
                                <td>Nama Produk</td>
                                <td>Qty</td>
                                <td>Harga/pcs</td>
                                <td>Total</td>
                                <td>Pengiriman</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $key)
                            <tr>
                                <td style="width:10%">
                                    <img src="<?= url('/') ?>/images/{{$key->gambar_bibit}}" width="100%">
                                </td>
                                <td>
                                    <b>{{$key->nama_bibit}}</b><br>
                                </td>
                                <td><b>{{$key->qty_keranjang}}</b></td>
                                <td><b>Rp {{number_format((float)$key->harga_bibit, 0, ',', '.')}}</b></td>
                                <td><b>Rp {{number_format((float)$key->price_keranjang, 0, ',', '.')}}</b></td>
                                <td><b>{{$key->kecamatan_name}}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-6">
                        <h5>Metode Pembayaran</h5>
                        <form action="<?= url('/') ?>/pelanggan/bayarsekarang" method="post">
                            {{csrf_field()}}
                            <div class="mb-5">
                                <select name="metodepembayaran" class="form-control">
                                    <option selected disabled>--PILIH METODE PEMBAYARAN--</option>
                                    @foreach($metodepembayaran as $mp)
                                    <option value="{{$mp->metodepembayaran_id}}">{{$mp->metodepembayaran_bank}} - {{$mp->metodepembayaran_name}} - {{$mp->metodepembayaran_numberbank}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div><button type="submit" class="btn_1">Bayar Sekarang</button></div>
                        </form>
                        @endif
                    </div>
<div class="col-6">
    <h5>Total Harga: <b>Rp {{ number_format((float)$sumPrice, 0, ',', '.') }}</b></h5>
    <h5>Ongkos Kirim:
        <?php
        $ongkir = 0;
        if ($keranjang->pengiriman_keranjang == 6) {
            $ongkir = 100000;
        } else {
            $ongkir = 150000;
        }
        $total = $ongkir + $sumPrice;
        ?>
        <b>Rp {{ number_format($ongkir, 0, ',', '.') }}</b>
    </h5>
    <h5>Total Harga: <b>Rp {{ number_format($total, 0, ',', '.') }}</b></h5>
    <h5>Pengiriman Keranjang: <b>{{ $keranjang->pengiriman_keranjang }}</b></h5>
</div>
                </div>
            </div>
        </div>
        <!-- /prod_info -->
    </div>
</div>
@endSection
