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

<form action="{{ url('/pelanggan/bibitborongan/checkout') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mx-4 my-2">
        <div class="mb-3">
            <label for="produkborong_select" class="form-label">Nama Bibit</label>
            <select name="produkborong_select" id="produkborong_select" class="form-select" required>
                <option selected disabled>Select an option or type</option>
                @foreach ($produkborong as $key)
                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="my-3">
            <label for="harga_bibit" class="form-label">Harga Satuan</label>
            <input name="harga_bibit" id="harga_bibit" class="form-control" type="text" placeholder="Harga" readonly>
        </div>
        <div class="mb-3">
            <label for="tanggal_tanam" class="form-label">Tanggal Tanam</label>
            <input name="tanggal_tanam" type="date" class="form-control" id="tanggal_tanam" value="{{ $tanggalTanam }}" required>
        </div>
        <div class="custom-select-container">
            <label for="lahan_select" class="form-label">Luas Lahan</label>
            <select name="lahan_select" id="lahan_select" class="form-select" required>
                <option selected disabled>Select an option or type</option>
                <optgroup label="m2">
                    @foreach ($lahan as $key)
                        @if ($key->status == "m2")
                            <option value="{{ $key->id }}">Luas Area : {{ $key->luas_area }} m2</option>
                        @endif
                    @endforeach
                </optgroup>
                <optgroup label="hektar">
                    @foreach ($lahan as $key)
                        @if ($key->status == "hektar")
                            <option value="{{ $key->id }}">Luas Area : {{ $key->luas_area }} hektar</option>
                        @endif
                    @endforeach
                </optgroup>
            </select>
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
            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
            <div class="custom-file">
                <input name="bukti_pembayaran" type="file" class="custom-file-input" id="customFile" required>
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
        <div class="my-3">
            <label for="pengiriman" class="form-label">Pilih Pengiriman</label>
            <select name="pengiriman" id="pengiriman" class="form-control" required>
                <option selected disabled>-- PILIH PENGIRIMAN --</option>
                <option value="0">Ambil di Toko</option>
                <optgroup label="PILIH DAFTAR ALAMAT">
                    @foreach($kecamatan as $key)
                        <option value="{{$key->kecamatan_id}}">{{$key->kecamatan_name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="my-3">
            <label for="metodepembayaran" class="form-label">Metode pembayaran</label>
            <select name="metodepembayaran" class="form-control" required>
                <option selected disabled>--PILIH METODE PEMBAYARAN--</option>
                @foreach($metodepembayaran as $mp)
                    <option value="{{ $mp->metodepembayaran_id }}">{{ $mp->metodepembayaran_bank }} - {{ $mp->metodepembayaran_name }} - {{ $mp->metodepembayaran_numberbank }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Checkout</button>
    </div>
</form>

<script>
    function hitungTotal() {
        var kuantitas = parseFloat(document.getElementById('jumlah_perbatang').value) || 0;
        var hargaSatuan = parseFloat(document.getElementById('harga_bibit').value) || 0;
        var ongkir = parseFloat(document.getElementById('pengiriman').value) || 0;

        var total = kuantitas * hargaSatuan + ongkir;
        document.getElementById('total').value = isNaN(total) ? '0.00' : total.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('jumlah_perbatang').addEventListener('input', hitungTotal);
        document.getElementById('harga_bibit').addEventListener('input', hitungTotal);
        document.getElementById('pengiriman').addEventListener('change', hitungTotal);
    });

    document.getElementById('lahan_select').addEventListener('change', function() {
        var lahanId = this.value;
        if (lahanId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/get-batang/' + lahanId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('jumlah_perbatang').value = response.jumlah_batang;
                    hitungTotal();
                } else if (xhr.readyState == 4) {
                    console.error('Error fetching data');
                    alert('Gagal mengambil data lahan');
                }
            };
            xhr.send();
        }
    });

    document.getElementById('produkborong_select').addEventListener('change', function() {
        var productId = this.value;
        if (productId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/get-price/' + productId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('harga_bibit').value = response.harga;
                    hitungTotal();
                } else if (xhr.readyState == 4) {
                    console.error('Error fetching data');
                    alert('Gagal mengambil data harga bibit');
                }
            };
            xhr.send();
        }
    });
</script>
@endsection
