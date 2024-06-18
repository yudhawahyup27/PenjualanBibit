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
                Anda Belum Membeli Produk
                <div><a href="{{ url('/') }}" class="btn_1">Beli Produk Sekarang</a></div>
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
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $key)
                            <tr>
                                <td style="width:10%">
                                    <img src="{{ url('/') }}/images/{{$key->gambar_bibit}}" width="100%">
                                </td>
                                <td>
                                    <b>{{$key->nama_bibit}}</b><br>
                                </td>
                                <td>
                                    <form action="{{ url('/pelanggan/keranjang/update') }}" method="POST" class="update-cart-form">
                                        @csrf
                                        <input type="hidden" name="cart_id" value="{{$key->id_keranjang}}">
                                        <input type="number" name="qty" value="{{$key->qty_keranjang}}" min="1" class="qty-input" data-price="{{$key->harga_bibit}}" data-id="{{$key->id_keranjang}}">
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td><b>Rp {{number_format((float)$key->harga_bibit, 0, ',', '.')}}</b></td>
                                <td><b class="total-price" id="total-{{$key->id_keranjang}}">Rp {{number_format((float)$key->price_keranjang, 0, ',', '.')}}</b></td>
                                <td><b>{{$key->kecamatan_name}}</b></td>
                                <td><a class="btn btn-danger" href="{{ url('/pelanggan/keranjang/' . $key->id_keranjang . '/hapus') }}"><i class="fa-solid fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div><a href="{{ url('/pelanggan/keranjang/bayar') }}" class="btn_1">Buat Pesanan</a></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endSection

@section('scripts')
<script>
    document.querySelectorAll('.qty-input').forEach(function(input) {
        input.addEventListener('change', function() {
            var price = parseFloat(this.dataset.price);
            var qty = parseInt(this.value);
            var total = price * qty;
            var id = this.dataset.id;
            document.getElementById('total-' + id).innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        });
    });
</script>
@endSection
