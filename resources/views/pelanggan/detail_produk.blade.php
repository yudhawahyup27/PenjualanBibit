@extends('pelanggan_core/core_afterlogin')
@section('css')
<!-- SPECIFIC CSS -->
<link href="css/product_page.css" rel="stylesheet">
<!-- YOUR CUSTOM CSS -->
<link href="css/custom.css" rel="stylesheet">

@endSection
@section('content')

<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-6">
            <div class="all">
                <img src="<?= url('/') ?>/images/{{$produk->gambar_bibit}}" width="100%">
            </div>
        </div>
        <div class="col-md-6">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="<?= url('/') ?>">Home</a></li>
                    <li><a href="<?= url('/') ?>">Detail</a></li>
                    <li>{{$produk->nama_bibit}}</li>
                </ul>
            </div>
            <!-- /page_header -->
            <div class="prod_info">
                <h1>{{$produk->nama_bibit}}</h1>
                <span class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i><em>4 reviews</em></span>
                <p>{{$produk->detail_bibit}}</p>
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="price_main"><span class="new_price">Rp <?= number_format((float)$produk->harga_bibit, 0, ',', '.') ?></span></div>
                    </div>
                </div>
                <div class="mt-3">
                    <h4>Pemesanan</h4>
                </div>
                <table class="table table-borderless">
                    <tbody>
                        <form id="orderForm" action="<?= url('/') ?>/pelanggan/detail/{{$produk->id_produk}}/beli" method="post">
                            {{csrf_field()}}
                            <tr>
                                <td>
                                    <h5>Kuantitas</h5>
                                </td>
                                <td><input id="quantityInput" type="number" min="0"  class="form-control" value="" name="qty" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Pengiriman Ke</h5>
                                </td>
                                <td>
                                    <select name="pengiriman" class="form-control" required>
                                        <option selected disabled>-- PILIH PENGIRIMAN --</option>
                                        <option disabled></option>
                                        <option disabled>-- AMBIL SENDIRI --</option>
                                        <option value="0">Ambil di Toko</option>
                                        <option disabled></option>
                                        <option disabled>-- PILIH DAFTAR ALAMAT --</option>
                                        @foreach($kecamatan as $key)
                                        <option value="{{$key->kecamatan_id}}">{{$key->kecamatan_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                    </tbody>
                </table>
                <div>
                    <p>*Pastikan alamat yang diisi sesuai dengan alamat yang diterima. Kesalahan pengiriman bukan tanggung jawab ecoomerce</p>
                </div>

                <div class="d-flex " style="gap: 20px">

                    <button type="submit" name="action" value="cart" class="btn btn-primary">Tambah Ke Keranjang</button>

                    <button id="showPopupBtn" class="btn btn-primary" type="button" style="display: none;">Beli Sekarang</button>
                    <a href="<?= url('/') ?>/pelanggan/keranjang/bayar" class="btn_1">Beli Langsung</a>
                </div>
                </form>
                <div class="col-2">
                </div>
            </div>
        </div>
        <!-- /prod_info -->
    </div>
</div>
</div>
{{-- Modal Tambah Laham --}}

<div class="modal fade" id="lahanmodal" tabindex="-1" role="dialog" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="quantityModalLabel">Peringatan</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama_bibit" class="form-label">Nama Bibit</label>

                <select class=" form-select">
                    <option selected disabled>Select an option or type</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="lainnya">lainnya</option>
                </select>
              </div>
            <div class="mb-3">
                <label for="tanggal_tanam" class="form-label">Tanggal Tanam</label>
                <input type="date" class="form-control" id="tanggal_tanam" placeholder="13/15/2024">
              </div>
              <div class="custom-select-container">
                <label for="nama_bibit" class="form-label">Luas Lahan</label>
                <select class=" form-select">
                    <option selected disabled>Select an option or type</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="lainnya">lainnya</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nama_bibit" class="form-label">Nama Bibit</label>
                <input class="form-control" type="text" placeholder="Disabled input" aria-label="Disabled input example" disabled>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="quantityModal" tabindex="-1" role="dialog" aria-labelledby="quantityModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quantityModalLabel">Peringatan</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Kuantitas Anda Sudah Lebih dari max kuantitas Eceran, <br>
        Silakan Pesan Borongan
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<script>

document.getElementById('quantityInput').addEventListener('input', function() {
    var quantity = document.getElementById('quantityInput').value;
    var showPopupBtn = document.getElementById('showPopupBtn');

    if (quantity >= 350) {
        $('#quantityModal').modal('show'); // Show the Bootstrap modal
        showPopupBtn.style.display = 'block'; // Show the "Beli Sekarang" button
    }else{
        showPopupBtn.style.display = 'none'; // Hide the "Beli Sekarang" button if quantity is less than 350
    }
});

document.getElementById('showPopupBtn').addEventListener('click', function() {
    $('#lahanmodal').modal('show');
});

document.getElementById('orderForm').addEventListener('submit', function(e) {
    var quantity = document.getElementById('quantityInput').value;
    if (quantity >= 350) {
        e.preventDefault();
        $('#quantityModal').modal('show');
    }
    if (!this.checkValidity()) {
        e.preventDefault(); // Prevent form submission if form is not valid
        alert('Please fill out all required fields.'); // Show alert for missing fields
    }
});

</script>


@endSection
