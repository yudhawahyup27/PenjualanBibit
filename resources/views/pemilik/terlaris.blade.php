@extends('pemilik_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Top 10 Produk Terjual</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Top 10 Produk Terjual</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Chart Penjualan 10 Produk Teratas
        </div>
        <div class="card-body">
            <canvas id="topSalesChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('topSalesChart').getContext('2d');
        const topSales = @json($topSales);

        const labels = topSales.map(item => item.nama_bibit);
        const data = topSales.map(item => item.terjual_bibit);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
