@extends('pelanggan_core.core_afterlogin')

@section('css')
<link href="{{ asset('css/product_page.css') }}" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-6">
            <div class="all">
                <img src="{{ asset('images/' . $produk->gambar_bibit) }}" width="100%">
            </div>
        </div>
        <div class="col-md-6">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/') }}">Detail</a></li>
                    <li>{{ $produk->nama_bibit }}</li>
                </ul>
            </div>
            <div class="prod_info">
                <h1>{{ $produk->nama_bibit }}</h1>
                <p>{{ $produk->detail_bibit }}</p>
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="price_main"><span class="new_price">Rp {{ number_format((float)$produk->harga_bibit, 0, ',', '.') }}</span></div>
                    </div>
                </div>
                <div class="mt-3">
                    <h4>Pemesanan</h4>
                </div>
                <table class="table table-borderless">
                    <tbody>
                        <form id="orderForm" action="{{ route('cart.create', $produk->id_produk) }}" method="post">
                            @csrf
                            <input type="hidden" id="productId" value="{{ $produk->id_produk }}">
                            <tr>
                                <td><h5>Kuantitas</h5></td>
                                <td><input id="quantityInput" type="number" min="0" class="form-control" value="" name="qty" required></td>
                            </tr>
                            <tr>
                                <td><h5>Provinsi</h5></td>
                                <td>
                                    <select name="province" id="province" class="form-control" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Kota</h5></td>
                                <td>
                                    <select name="city" id="city" class="form-control" required>
                                        <option value="">Pilih Kota</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="detail_rumah" class="form-label h5">Detail Rumah</label>
                                </td>
                                    <td>
                                        <div class="my-3">
                                            <textarea name="detail_rumah" id="detail_rumah" class="form-control " rows="3" placeholder="Detail Rumah" required></textarea>
                                        </div>
                                    </td>
                                </tr>
                            <tr>
                                <td><h5>Kurir</h5></td>
                                <td>
                                    <select name="courier" id="courier" class="form-control" required>
                                        <option value="jne">JNE</option>
                                        <option value="pos">Pos Indonesia</option>
                                        <option value="tiki">TIKI</option>
                                    </select>
                                </td>
                            </tr>
                            <td><h5>Total Berat</h5></td>
                            <td><input id="totalWeightInput" name="totalWeightInput" type="text" class="form-control" value="" readonly></td>
                            <tr>
                                <td>
                                    <button type="submit" name="action" value="cart" class="btn_1" id="cartBtn">Add to Cart</button>
                                </td>
                                <td>
                                    <button type="submit" name="action" value="beli_langsung" class="btn_1" id="buyNowBtn">Beli Langsung</button>
                                </td>
                            </tr>
                            <tr>
                                <a id="showPopupBtn" class="btn btn-success" href="{{ route('borongan.checkout', ['productId' => $produk->id_produk]) }}" style="display: none;">Beli Dengan Luas Lahan</a>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah Lahan -->
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
    document.addEventListener('DOMContentLoaded', function () {
     var pengirimanSelect = document.getElementById('pengiriman');
     var detailRumahTextarea = document.getElementById('detail_rumah');

     pengirimanSelect.addEventListener('change', function () {
         var selectedOption = this.options[this.selectedIndex];
         var alamat = selectedOption.getAttribute('data-alamat');
         var deskripsi = selectedOption.getAttribute('data-deskripsi');
         var kecamatan = selectedOption.getAttribute('data-kecamatan');

         if (this.value == "0") { // Ambil di Toko
             detailRumahTextarea.value = 'Kertosono - Jawa Timur';
             detailRumahTextarea.readOnly = true;
         } else {
             detailRumahTextarea.readOnly = false;
             if (alamat && deskripsi) {
                 detailRumahTextarea.value = `${alamat}\n${deskripsi}\n${kecamatan}`;
             } else {
                 detailRumahTextarea.value = '';
             }
         }
     });
 });

     document.getElementById('quantityInput').addEventListener('input', function() {
         var quantity = document.getElementById('quantityInput').value;
         var showPopupBtn = document.getElementById('showPopupBtn');
         var productId = document.getElementById('productId').value;

         if (quantity >= 350) {
             $('#quantityModal').modal('show'); // Show the Bootstrap modal
             showPopupBtn.style.display = 'block'; // Show the "Beli Dengan Luas Lahan" button
             showPopupBtn.href = "{{ route('borongan.checkout', ['productId' => $produk->id_produk]) }}"; // Set the correct URL using Laravel route helper
         } else {
             showPopupBtn.style.display = 'none'; // Hide the "Beli Dengan Luas Lahan" button if quantity is less than 350
         }
     });

     document.getElementById('showPopupBtn').addEventListener('click', function() {
         // No event.preventDefault() needed here
         $('#lahanmodal').modal('show'); // Show the modal when "Beli Dengan Luas Lahan" button is clicked
     });

     document.getElementById('orderForm').addEventListener('submit', function(e) {
         var quantity = document.getElementById('quantityInput').value;
         var pengiriman = document.getElementById('pengiriman').value;

         if (pengiriman === '-- PILIH PENGIRIMAN --') {
             e.preventDefault();
             alert('Please select a valid pengiriman option.');
         }

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
<script>
    document.getElementById('quantityInput').addEventListener('input', function() {
        var quantity = this.value;
        var totalWeightInput = document.getElementById('totalWeightInput');
        var totalWeight = Math.ceil(quantity / 30) * 1000; // Hitung total berat dalam gram

        totalWeightInput.value = totalWeight + ' gram'; // Set nilai total berat pada input
    });
</script>
<script>

    document.getElementById('province').addEventListener('change', function () {
        var provinceId = this.value;
        fetch('/cities/' + provinceId)
            .then(response => response.json())
            .then(data => {
                var citySelect = document.getElementById('city');
                citySelect.innerHTML = '<option value="">Pilih Kota</option>';
                data.forEach(function (city) {
                    var option = document.createElement('option');
                    option.value = city.city_id;
                    option.textContent = city.city_name;
                    citySelect.appendChild(option);
                });
            });
    });
</script>
@endsection
