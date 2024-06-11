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
                <h3>Pesanan Saya</h3>
                <div class="mb-2">
                    <table>
                        <thead>
                            <tr>
                                <td>Kode Transaksi :</td>
                                <td>{{$cart->kode_transaksi}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Pembelian :</td>
                                <td>Rp {{number_format((float)$cart->total_transaksi, 0, ',', '.')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <div>
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <h5>Pesanan Sedang Dibuat <br></h5>
                                @if($getStatusTransaksi_one)
                                    {{ $getStatusTransaksi_one->statuspengiriman_created }}
                                @else
                                    <span>Status not available</span>
                                @endif
                            </div>
                            <div>
                                <h5>Konfirmasi Pembayaran</h5>
                                @if($getStatusTransaksi_two)
                                    {{ $getStatusTransaksi_two->statuspengiriman_created }}
                                @else
                                    <span>Status not available</span>
                                @endif
                            </div>
                            <div>
                                <h5>Dikirim</h5>
                                @if($getStatusTransaksi_three)
                                    {{ $getStatusTransaksi_three->statuspengiriman_created }}
                                @else
                                    <span>Status not available</span>
                                @endif
                            </div>
                            <div>
                                <h5>DiTerima</h5>
                                @if($getStatusTransaksi_four)
                                    {{ $getStatusTransaksi_four->statuspengiriman_created }}
                                @else
                                    <span>Status not available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h5>List Pembelian Bibit</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Gambar</td>
                                <td>Nama Bibit</td>
                                <td>Harga</td>
                                <td>Qty</td>
                                <td>Total</td>
                                <td>Pengiriman</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getTransaction as $keys)
                            <tr>
                                <td style="width: 10%;">
                                    <img src="<?= url('/') ?>/images/{{$keys->gambar_bibit}}" width="100%">
                                </td>
                                <td>{{$keys->nama_bibit}}</td>
                                <td>Rp {{number_format((float)$keys->harga_bibit, 0,',','.')}}</td>
                                <td>{{$keys->qty_keranjang}}</td>
                                <td>Rp {{number_format((float)$keys->price_keranjang, 0,',','.')}}</td>
                                <td>{{$keys->kecamatan_name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div></div>
            </div>
        </div>
        <!-- /prod_info -->
    </div>
</div>
@endSection
