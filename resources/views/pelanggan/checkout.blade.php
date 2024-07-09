@extends('pelanggan_core.core_afterlogin')

@section('css')
    <!-- SPECIFIC CSS -->
    <link href="{{ asset('css/product_page.css') }}" rel="stylesheet">
    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payment.process') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mx-4 my-2">
            <div class="mb-3">
                <label for="produkborong_select" class="form-label">Nama Bibit</label>
                <select name="produkborong_select" id="produkborong_select" class="form-select" required>
                    <option value="" selected disabled>Select an option or type</option>
                    @foreach ($produkborong as $key)
                        <option value="{{ $key->id_produk }}" {{ isset($selectedProductId) && $selectedProductId == $key->id_produk ? 'selected' : '' }}>
                            {{ $key->nama_bibit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="my-3">
                <label for="harga_bibit" class="form-label">Harga Satuan</label>
                <input name="harga_bibit" id="harga_bibit" class="form-control" type="text" placeholder="Harga" readonly>
            </div>
            <div class="mb-3">
                <label for="tanggal_tanam" class="form-label">Tanggal Pengiriman</label>
                <input name="tanggal_tanam" type="date" class="form-control" id="tanggal_tanam" value="{{ $tanggalTanam }}" disabled required>
            </div>
            <div class="custom-select-container">
                <label for="lahan" class="form-label">Luas Lahan</label>
                <input name="lahan" id="lahan" class="form-control" type="text" placeholder="Lahan" required>
            </div>
            <div class="my-3">
                <label for="jumlah_perbatang" class="form-label">Kuantitas Bibit</label>
                <input name="jumlah_perbatang" id="jumlah_perbatang" class="form-control" type="number" placeholder="Kuantitas Bibit" required disabled>
            </div>
            <div class="my-3">
                <label for="total" class="form-label">Total Bayar</label>
                <input name="total" id="total" class="form-control" type="text" placeholder="Total Bayar" readonly>
            </div>
            <div class="my-3">
                <label for="pengiriman" class="form-label">Pilih Pengiriman</label>
                <select name="pengiriman" id="pengiriman" class="form-control" required>
                    <option value="" selected disabled>-- PILIH PENGIRIMAN --</option>
                    <option value="0">Ambil di Toko</option>
                    @foreach($rumah as $key)
                    <option value="{{ $key->ongkir }}" data-alamat="{{ $key->alamatpengiriman_alamat }}" data-deskripsi="{{ $key->alamatpengiriman_deskripsi }}" data-kecamatan="{{ $key->kecamatan_name }}">
                        Rumah
                    </option>
                @endforeach
                    <optgroup label="PILIH DAFTAR ALAMAT">
                        @foreach($kecamatan as $key)
                            <option value="{{ $key->ongkir}}">{{ $key->kecamatan_name }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="my-3">
                <label for="detail_rumah" class="form-label">Detail Rumah</label>
                <textarea name="detail_rumah" id="detail_rumah" class="form-control" placeholder="Detail Rumah" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn_1 full-width mb-2" id="bayarButton">Bayar</button>
            </div>
        </div>
    </form>

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
                    anda memasukan batas minimal dari luas lahan,
                    Kuantitas Anda Sudah Lebih dari Minimal kuantitas beli borongon, <br>
                    Silakan Pesan Eceran
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="redirectLahanBtn" class="btn btn-primary" href="/">Beli Bibit Eceran</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('paymentForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Perform client-side validation if necessary

                // Submit form asynchronously
                fetch('{{ route("payment.process") }}', {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.snapToken) {
                        // Redirect to Midtrans payment page with snapToken
                        snap.pay(data.snapToken, {
                            onSuccess: function(result){
                                if (result.finish_redirect_url) {
                                    window.location.href = result.finish_redirect_url;
                                }
                            },
                            onPending: function(result){
                                if (result.finish_redirect_url) {
                                    window.location.href = result.finish_redirect_url;
                                }
                            },
                            onError: function(result){
                                console.error('Error processing payment:', result);
                                alert('Terjadi kesalahan saat pemrosesan pembayaran.');
                            }
                        });
                    } else {
                        console.error('Failed to get Snap token from server.');
                        alert('Gagal mendapatkan token pembayaran dari server.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim permintaan pembayaran.');
                });
            });
        });
    </script>

    <script>
   document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('lahan').addEventListener('input', function () {
        var area = parseFloat(this.value) || 0;
        var quantity = calculateQuantity(area);
        document.getElementById('jumlah_perbatang').value = quantity;
        hitungTotal();
    });

    var pengirimanSelect = document.getElementById('pengiriman');
    var detailRumahTextarea = document.getElementById('detail_rumah');

    pengirimanSelect.addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var alamat = selectedOption.getAttribute('data-alamat');
        var deskripsi = selectedOption.getAttribute('data-deskripsi');
        var kecamatan = selectedOption.getAttribute('data-kecamatan');

        if (this.value == "0") { // Ambil di Toko
            detailRumahTextarea.value = 'Kertosono - Jawa Timur';
            detailRumahTextarea.disabled = true;
        } else {
            detailRumahTextarea.disabled = false;
            if (alamat && deskripsi) {
                detailRumahTextarea.value = `${alamat}\n${deskripsi}\n${kecamatan}`;
            } else {
                detailRumahTextarea.value = '';
            }
        }

        hitungTotal(); // Recalculate total when shipping changes
    });

    document.getElementById('jumlah_perbatang').addEventListener('input', hitungTotal);
    document.getElementById('harga_bibit').addEventListener('input', hitungTotal);
    document.getElementById('pengiriman').addEventListener('change', hitungTotal);

    document.getElementById('produkborong_select').addEventListener('change', function () {
        var productId = this.value;
        fetchProductPrice(productId);
    });

    function fetchProductPrice(productId) {
        fetch(`/produkborong/price/${productId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('harga_bibit').value = data.harga_bibit;
                hitungTotal(); // Update total when price changes
            })
            .catch(error => {
                console.error('Error fetching product price:', error);
            });
    }

    function hitungTotal() {
        var kuantitas = parseFloat(document.getElementById('jumlah_perbatang').value) || 0;
        var hargaSatuan = parseFloat(document.getElementById('harga_bibit').value) || 0;
        var ongkir = parseFloat(document.getElementById('pengiriman').value) || 0;

        var total = (kuantitas * hargaSatuan) + ongkir;
        document.getElementById('total').value = total;
    }

    function calculateQuantity(area) {
        var total = area * 2;
        let bayarButton = document.getElementById('bayarButton');

        if (total < 175) {
            bayarButton.disabled = true;
            $('#quantityModal').modal('show'); // Show the modal
        } else {
            bayarButton.disabled = false;
        }

        return total;
    }

    function formatRupiah(number) {
        var rupiah = '';
        var numberString = number.toString();
        var sisa = numberString.length % 3;
        var rupiah = numberString.substr(0, sisa);
        var ribuan = numberString.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }

    // Initialize harga_bibit if there's a selected product
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('productId');

    if (productId) {
        document.getElementById('produkborong_select').value = productId;
        fetchProductPrice(productId);
    }

    document.getElementById('produkborong_select').dispatchEvent(new Event('change'));
    document.getElementById('pengiriman').dispatchEvent(new Event('change'));
});
    </script>
@endsection
