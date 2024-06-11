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
                        <h3 class="text-center my-4"><b>Alamat Pengiriman : Ubah Alamat</b></h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/') ?>/alamat-pengiriman/ubah/{{$alamat->alamatpengiriman_id}}" method="post">
                                {{csrf_field()}}
                                <div class="form-floating mb-3">
                                    <label>Kecamatan</label>
                                    <select name="kecamatan" class="form-control">
                                        <option selected disabled>-- PILIH KECAMATAN --</option>
                                        @foreach($kecamatan as $key)
                                            <option <?php if ($key->kecamatan_id == $alamat->alamatpengiriman_kecamatan_id) {
                                                echo 'selected';
                                            } ?> value="{{$key->kecamatan_id}}">{{$key->kecamatan_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-floating mb-3">
                                    <label>Alamat</label>
                                    <input class="form-control" type="text" name="alamat" placeholder="Isikan Alamat" value="{{$alamat->alamatpengiriman_alamat}}" />
                                </div>
                                <div class="form-floating mb-3">
                                    <label>Deskripsi Alamat <small>Cth: (Pagar Warna Coklat)</small></label>
                                    <input class="form-control" type="text" name="deskripsi" placeholder="Isikan Deskripsi Alamat" value="{{$alamat->alamatpengiriman_deskripsi}}" />
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block" href="login.html">Ubah Alamat Sekarang</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/carousel-->

</main>
@endSection