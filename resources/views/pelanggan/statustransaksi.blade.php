@extends('pelanggan_core/core_afterlogin')
@section('css')
<!-- SPECIFIC CSS -->
<link href="css/product_page.css" rel="stylesheet">
<!-- YOUR CUSTOM CSS -->
<link href="css/custom.css" rel="stylesheet">

@endSection
@section('content')
<div class="container mb">

    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <div class="text-center">
                <h3>Pesanan Saya</h3>
            </div>
            <div>
                <div class="row">
                    <div class="table-responsive" style="margin-bottom: 300px;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Dibuat</td>
                                    <td>Kode Transaksi</td>
                                    <td>Total Transaksi</td>
                                    <td>#</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getTransaksi as $key)
                                <tr>
                                    <td>
                                        {{$key->created_transaksi}}
                                    </td>
                                    <td>
                                        {{$key->kode_transaksi}}
                                    </td>
                                    <td>
                                        Rp {{number_format((float)$key->total_transaksi,0,',','.')}}
                                    </td>
                                    <td><a href="<?= url('/') ?>/pelanggan/statustransaksi/detail/{{$key->id_transaksi}}" class="btn btn-primary">Cek Pesanan</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /prod_info -->
    </div>
</div>
@endSection
