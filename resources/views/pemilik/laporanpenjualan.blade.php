@extends('pemilik_core/core')

@section('content')
    <!-- Your HTML and Blade code here -->

    <h1>Laporan Penjualan</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
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
                                <td>{{ $laporan->kode_bibit }}</td>
                                <td>{{ $laporan->nama_bibit }}</td>
                                <td>{{ $laporan->harga_beli }}</td>
                                <td>{{ $laporan->terjual }}</td>
                                <td>{{ $laporan->tanggal_transaksi }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
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
        </div>
    </div>


@endsection
