@extends('pelanggan_core/core_afterlogin')
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
                    @foreach($produk ?? [] as $key)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="grid_item">
                                <figure>
                                    <a href="/pelanggan/detail/{{ $key->id_produk }}">
                                        @php
                                            $images = $key->gambar_bibit ? $key->gambar_bibit : 'noimage.png';
                                        @endphp
                                        <img class="img-fluid lazy loaded" src="{{ url('/') }}/images/{{ $images }}" data-src="{{ url('/') }}/images/{{ $images }}" alt="" data-was-processed="true">
                                    </a>
                                </figure>
                                <div class="rating">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="icon-star voted"></i>
                                    @endfor
                                </div>
                                <a href="/pelanggan/detail/{{ $key->id_produk }}">
                                    <h3>{{ $key->nama_bibit }}</h3>
                                </a>
                                <div class="price_box">
                                    <span class="new_price">Rp {{ number_format($key->harga_bibit, 0,',','.') }}</span>
                                </div>
                                <ul>

                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="icon_drag_mobile"></div>
        </div>
    </main>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="quantityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="quantityModalLabel">Peringatan</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <P class="text-center fs-4">Pesan bibit sekarang</P>
                <div class="d-flex justify-content-center" style="gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ya</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                </div>
                </div>
          </div>
        </div>
      </div>
    <!-- Memanggil jQuery dan kode JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#modal').modal('show');
        });
    </script>
@endsection
