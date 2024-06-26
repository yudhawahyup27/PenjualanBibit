@extends('pelanggan_core/core_afterlogin')
@section('css')

@endSection
@section('content')
<main style="margin-bottom: 20.6px;">
    <div id="carousel-home">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center my-4"><b>Alamat Pengiriman</b></h3>
                            <a href="/" class="btn-primary p-2 rounded-md">Back To Website</a>
                        </div>
                        <div class="card-body">
                            @if($countAlamat == 0)
                            <div class="text-center">
                                <h5>Anda Belum Memiliki Alamat</h5>
                                <a class="btn btn-primary" href="<?= url('/') ?>/alamat-pengiriman/tambah">Buat Alamat Sekarang</a>
                            </div>
                            @elseif($countAlamat > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Alamadt</td>
                                        <td>Kecamatan</td>
                                        <td>Deskripsi</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alamat as $key)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$key->alamatpengiriman_alamat}}</td>
                                        <td>{{$key->kecamatan_name}}</td>
                                        <td>{{$key->alamatpengiriman_deskripsi}}</td>
                                        <td>
                                            <a href="<?= url('/') ?>/alamat-pengiriman/ubah/{{$key->alamatpengiriman_id}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="<?= url('/') ?>/alamat-pengiriman/hapus/{{$key->alamatpengiriman_id}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                <p>*Pastikan alamat yang diisi sesuai dengan alamat yang diterima. Kesalahan pengiriman bukan tanggung jawab ecoomerce</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/carousel-->

</main>
@endSection


<script>
    // setTimeout(function() {
    //     window.location.href = "{{ url('/') }}";
    // }, 1000);
</script>
