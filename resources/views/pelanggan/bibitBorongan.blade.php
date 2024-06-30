@extends('pelanggan_core.core_afterlogin')

@section('css')
    <!-- SPECIFIC CSS -->
    <link href="css/product_page.css" rel="stylesheet">
    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
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

<form action="{{ url('/pelanggan/bibitborongan') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mx-4 my-2">
        <div class="mb-3">
            <label for="produkborong_select" class="form-label">Nama Bibit</label>
            <select name="produkborong_select" id="produkborong_select" class="form-select" required>
                <option selected disabled>Select an option or type</option>
                @foreach ($produkborong as $key)
                    <option value="{{ $key->id_produk }}">{{ $key->nama_bibit }}</option>
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
            <input name="jumlah_perbatang" id="jumlah_perbatang" class="form-control" type="number" placeholder="Kuantitas Bibit" required>
        </div>
        <div class="my-3">
            <label for="total" class="form-label">Total Bayar</label>
            <input name="total" id="total" class="form-control" type="text" placeholder="Total Bayar" readonly>
        </div>
        <div class="my-3">
            <label for="pengiriman" class="form-label">Pilih Pengiriman</label>
            <select name="pengiriman" id="pengiriman" class="form-control" required>
                <option selected disabled>-- PILIH PENGIRIMAN --</option>
                <option value="0">Ambil di Toko</option>
                @foreach($rumah as $key)
                <option value="{{ $key->alamatpengiriman_id }}" data-alamat="{{ $key->alamatpengiriman_alamat }}" data-deskripsi="{{ $key->alamatpengiriman_deskripsi }}" data-kecamatan="{{ $key->kecamatan_name }}">
                 rumah
                </option>
            @endforeach
                <optgroup label="PILIH DAFTAR ALAMAT">
                    @foreach($kecamatan as $key)
                        <option value="{{$key->kecamatan_id}}">{{$key->kecamatan_name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="my-3">
            <label for="detail_rumah" class="form-label">Detail Rumah2</label>
            <textarea name="detail_rumah" id="detail_rumah" class="form-control" placeholder="Detail Rumah" ></textarea>
        </div>
        <div class="my-3">
            <label for="metodepembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metodepembayaran" class="form-control" required>
                <option selected disabled>-- PILIH METODE PEMBAYARAN --</option>
                @foreach($metodepembayaran as $mp)
                    <option value="{{ $mp->metodepembayaran_id }}">{{ $mp->metodepembayaran_bank }} - {{ $mp->metodepembayaran_name }} - {{ $mp->metodepembayaran_numberbank }}</option>
                @endforeach
            </select>
        </div>
        <div class="my-3">
            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
            <div class="custom-file">
                <input name="bukti_pembayaran" type="file" class="custom-file-input" id="customFile" required>
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Checkout</button>
    </div>
</form>

<script>
    document.getElementById('lahan').addEventListener('input', function () {
        var area = parseFloat(this.value) || 0;
        if (area < 175) {
            alert('Luas lahan minimal 175');
            this.value = '';
            document.getElementById('jumlah_perbatang').value = '';
        } else {
            var quantity = calculateQuantity(area);
            document.getElementById('jumlah_perbatang').value = quantity;
            hitungTotal();
        }
    });

    document.getElementById('pengiriman').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var alamat = selectedOption.getAttribute('data-alamat');
    var deskripsi = selectedOption.getAttribute('data-deskripsi');
    var kecamatan = selectedOption.getAttribute('data-kecamatan');

    if (alamat && deskripsi) {  // Only if alamat and deskripsi are present
        document.getElementById('detail_rumah').value = `Alamat: ${alamat}\nDeskripsi: ${deskripsi}\nKecamatan: ${kecamatan}`;
    } else {
        document.getElementById('detail_rumah').value = '';  // Clear the textarea if not a 'rumah' selection
    }
    hitungTotal();
});

    document.getElementById('produkborong_select').addEventListener('change', function() {
        var productId = this.value;
        fetchProductPrice(productId);
    });

    document.getElementById('pengiriman').addEventListener('change', function() {
        hitungTotal();
    });

    function fetchProductPrice(productId) {
        if (productId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/get-price/' + productId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('harga_bibit').value = response.harga_borong;
                    hitungTotal();
                } else if (xhr.readyState == 4) {
                    console.error('Error fetching data');
                    alert('Gagal mengambil data harga bibit');
                }
            };
            xhr.send();
        }
    }

    function hitungTotal() {
    var kuantitas = parseFloat(document.getElementById('jumlah_perbatang').value) || 0;
    var hargaSatuan = parseFloat(document.getElementById('harga_bibit').value) || 0;
    var ongkir = parseFloat(document.getElementById('pengiriman').value) || 0;

    var total = kuantitas * hargaSatuan + ongkir;
    document.getElementById('total').value = formatRupiah(total.toString());  // Format the total as rupiah
}

function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp ' + rupiah;
}

    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            document.getElementById('payment_method').value = card.getAttribute('data-method-code');
        });
    });

    function calculateQuantity(area) {
        var total = area * 2; // Adjust the calculation logic as needed
        return total;
    }
</script>
@endsection
