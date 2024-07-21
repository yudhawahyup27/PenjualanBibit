@extends('pemilik_core.core')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="card mb-4">
        <a class="btn btn-primary float-end w-4" href="/pemilik/dashboard2">Statik Penjualan Borongan</a>
        <div class="card-header">
            Dashboard Data (Eceran)
        </div>
        <div class="card-body">

            {{-- Filter eceran --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="filterStartDateEceran" class="form-label">Start Date:</label>
                    <input type="date" class="form-control" id="filterStartDateEceran" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}">
                </div>
                <div class="col">
                    <label for="filterEndDateEceran" class="form-label">End Date:</label>
                    <input type="date" class="form-control" id="filterEndDateEceran" name="end_date" value="{{ $endDate ? $endDate->format('Y-m-d') : '' }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Eceran Transactions</h5>
                    <canvas id="eceranChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInputEceran = document.getElementById('filterStartDateEceran');
        const endDateInputEceran = document.getElementById('filterEndDateEceran');
        let eceranChart;

        function updateEceranChart() {
            const startDate = startDateInputEceran.value;
            const endDate = endDateInputEceran.value;

            fetch(`{{ route('dashboard') }}?start_date=${startDate}&end_date=${endDate}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('AJAX Response:', data);

                    let labels, transactionData;

                    if (startDate || endDate) {
                        labels = data.transactions.map(transaction => {
                            const date = new Date(transaction.created_transaksi);
                            return `${date.getDate()} ${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;
                        });
                    } else {
                        labels = data.transactions.map(transaction => {
                            const date = new Date(transaction.created_transaksi);
                            return `${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;
                        });
                    }

                    transactionData = data.transactions.map(transaction => transaction.total_transaksi);

                    const chartData = {
                        labels: labels,
                        datasets: [{
                            label: 'Total Transaksi Eceran',
                            data: transactionData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    };

                    if (eceranChart) {
                        eceranChart.destroy();
                    }

                    const ctx = document.getElementById('eceranChart').getContext('2d');
                    eceranChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        startDateInputEceran.addEventListener('change', updateEceranChart);
        endDateInputEceran.addEventListener('change', updateEceranChart);

        updateEceranChart();
    });
</script>
@endsection
