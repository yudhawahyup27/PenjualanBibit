@extends('pelanggan_core/core_afterlogin')

@section('css')
<!-- SPECIFIC CSS -->
<link href="css/product_page.css" rel="stylesheet">
<!-- YOUR CUSTOM CSS -->
<link href="css/custom.css" rel="stylesheet">
@endsection

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
                                <td>{{ $cart->kode_transaksi }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Pembelian :</td>
                                <td>Rp {{ number_format((float)$cart->total_transaksi, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                <h5>Status Transaksi</h5>
                @if ($statusTransaksis->isEmpty())
                    <p>Belum ada status untuk transaksi ini.</p>
                @else
                   <h5>{{ $statusTransaksis->last()->status_name }}</h5>
                @endif
            </div>
            <div class="mt-4">
                <h5>List Pembelian Produk</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                                {{-- <th>Pengiriman</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getTransaction as $key)
                            <tr>
                                <td style="width: 10%;">
                                    <img src="{{ url('/') }}/images/{{ $key->gambar_bibit }}" width="100%">
                                </td>
                                <td>{{ $key->nama_bibit }}</td>
                                <td>Rp {{ number_format((float)$key->harga_bibit, 0, ',', '.') }}</td>
                                <td>{{ $key->qty_keranjang }}</td>
                                <td>Rp {{ number_format((float)$key->price_keranjang    , 0, ',', '.') }}</td>
                                {{-- <td>{{ $key->kecamatan_name }}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
