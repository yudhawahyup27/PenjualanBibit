@extends('pelanggan_core/core_afterlogin')

@section('css')
<!-- SPECIFIC CSS -->
<link href="{{ asset('css/product_page.css') }}" rel="stylesheet">
<!-- YOUR CUSTOM CSS -->
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

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
                <script>
                    window.location.href = '{{ url('/pengguna/keranjang') }}';
                </script>
                <div><a href="{{ url('/') }}" class="btn_1">Beli Produk Sekarang</a></div>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Harga/pcs</th>
                                <th>Total</th>
                                <th>Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                            <tr>
                                <td style="width:10%">
                                    <img src="{{ url('/images/' . $item->gambar_bibit) }}" width="100%">
                                </td>
                                <td>
                                    <b>{{ $item->nama_bibit }}</b><br>
                                </td>
                                <td><b>{{ $item->qty_keranjang }}</b></td>
                                <td><b>Rp {{ number_format($item->harga_bibit, 0, ',', '.') }}</b></td>
                                <td><b>Rp {{ number_format($item->price_keranjang, 0, ',', '.') }}</b></td>
                                {{-- <td><b>{{ $item->kecamatan_name }}</b></td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            @if($countCart > 0)
            <div>
                <div class="row">
                    <div class="col-6">
                        <form id="payment-form" action="{{ url('/pelanggan/processpayment') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="json" id="json_callback">
                            <div><button type="button" id="pay-button" class="btn_1">Bayar Sekarang</button></div>
                        </form>
                    </div>
                    <div class="col-6">
                        <h5>Total Harga: <b>Rp {{ number_format($sumPrice, 0, ',', '.') }}</b></h5>
                        @if(isset($keranjang))
                        <h5>Ongkos Kirim:
                            <?php
                            // Konversi $ongkir ke float jika perlu
                            $ongkir = is_numeric($keranjang->ongkir) ? (float) $keranjang->ongkir : 0;
                            //  dd($ongkir);
                            // Konversi $sumPrice ke float jika perlu
                            $sumPrice = is_numeric($sumPrice) ? (float) $sumPrice : 0;

                            $total = $ongkir + $sumPrice;
                            ?>
                            <b>Rp {{ number_format($ongkir, 0, ',', '.') }}</b>
                        </h5>
                        <h5>Total Harga: <b>Rp {{ number_format($total, 0, ',', '.') }}</b></h5>

                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Midtrans Scripts -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            // Optional callback functions
            onSuccess: function(result){
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
            },
            onPending: function(result){
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
            },
            onError: function(result){
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
            }
        });
    };
</script>

@endsection
