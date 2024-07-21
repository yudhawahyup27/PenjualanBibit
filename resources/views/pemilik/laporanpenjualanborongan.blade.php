@extends('pemilik_core/core')

@section('content')
    <div class="container">
        <h1 class="mt-4">Laporan Penjualan</h1>
        <a href="/pemilik/laporanpenjualan" class="btn-success btn p-1 float-end">Lihat Laporan Eceran</a>
        <div class="row mb-4">
            <form action="{{ route('laporanpenjualanborongan') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="start">Filter Start Date</label>
                        <input type="date" name="start" id="start" value="{{ request('start') }}" class="form-control">

                        <label for="end">End Date</label>
                        <input type="date" name="end" id="end" value="{{ request('end') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card mb-4">
            <div class="card-header">Data Laporan Penjualan</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Harga Beli</th>
                                <th>Terjual</th>
                                <th>Tanggal Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $laporan)
                                <tr>
                                    <td>{{ $laporan->kode_transaksi }}</td>
                                    <td>{{ 'Rp ' . number_format($laporan->harga_beli, 0, ',', '.') }}</td>
                                    <td>{{ $laporan->terjual }}</td>
                                    <td>{{ $laporan->tanggal_transaksi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Previous Page Link -->
                @if ($data->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" tabindex="-1">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>
                @endif

                <!-- Pagination Elements -->
                @for ($page = 1; $page <= $data->lastPage(); $page++)
                    <li class="page-item {{ ($page == $data->currentPage()) ? 'active' : '' }}">
                        <a class="page-link" href="{{ $data->url($page) }}">{{ $page }}</a>
                    </li>
                @endfor

                <!-- Next Page Link -->
                @if ($data->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endsection
