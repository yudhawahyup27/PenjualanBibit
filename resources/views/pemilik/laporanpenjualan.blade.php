@extends('pemilik_core/core')

@section('content')
    <div class="container">
        <h1 class="mt-4">Laporan Penjualan</h1>
        <a href="/pemilik/laporanpenjualanborongan" class="btn-success btn p-1 float-end">Lihat Laporan Borongan</a>
        <div class="row mb-4">
            <form action="{{ route('laporanpenjualan') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="selectedDay">Filter Hari:</label>
                        <select name="selectedDay" id="selectedDay" class="form-control">
                            <option value="">Pilih Hari</option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ $selectedDay == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="selectedMonth">Filter Bulan:</label>
                        <select name="selectedMonth" id="selectedMonth" class="form-control">
                            <option value="">Pilih Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="selectedYear">Filter Tahun:</label>
                        <select name="selectedYear" id="selectedYear" class="form-control">
                            <option value="">Pilih Tahun</option>
                            @for ($i = date('Y'); $i >= date('Y') - 10; $i--)
                                <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
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
                                <th>Kode Bibit</th>
                                <th>Nama Bibit</th>
                                <th>Harga Beli</th>
                                <th>Terjual</th>
                                <th>Tanggal Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $laporan)
                                <tr>
                                    <td>{{ $laporan->kode_transaksi }}</td>
                              <td>{{ $laporan->kode_transaksi }}</td>
                                     <td>{{ $laporan->nama_bibit }}</td>
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
