@extends('pemilik_core.core')

@section('content')
<div class="content">
    <div class="card mx-4">
        <a class="btn btn-primary float-end w-4" href="/pemilik/dashboard22">Statik Penjualan Eceran</a>
        <div class="card-body">
            {{-- Filter borong --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="startDateBorong" class="form-label">Start Date (Borong):</label>
                    <input type="date" class="form-control" id="startDateBorong" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}">
                </div>
                <div class="col">
                    <label for="endDateBorong" class="form-label">End Date (Borong):</label>
                    <input type="date" class="form-control" id="endDateBorong" name="end_date" value="{{ $endDate ? $endDate->format('Y-m-d') : '' }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Borong Transactions</h5>
                    <canvas id="borongChart"></canvas>
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
        const startDateInputBorong = document.getElementById('startDateBorong');
        const endDateInputBorong = document.getElementById('endDateBorong');
        let borongChart;

        function updateBorongChart() {
            const startDate = startDateInputBorong.value;
            const endDate = endDateInputBorong.value;

            fetch(`{{ route('dashboard2') }}?start_date=${startDate}&end_date=${endDate}`, {
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
                            const date = new Date(transaction.created_at);
                            return `${date.getDate()} ${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;
                        });
                    } else {
                        labels = data.transactions.map(transaction => {
                            const date = new Date(transaction.created_at);
                            return `${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;
                        });
                    }

                    transactionData = data.transactions.map(transaction => transaction.total_transaksi);

                    const chartData = {
                        labels: labels,
                        datasets: [{
                            label: 'Total Transaksi Borong',
                            data: transactionData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    };

                    if (borongChart) {
                        borongChart.destroy();
                    }

                    const ctx = document.getElementById('borongChart').getContext('2d');
                    borongChart = new Chart(ctx, {
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

        startDateInputBorong.addEventListener('change', updateBorongChart);
        endDateInputBorong.addEventListener('change', updateBorongChart);

        updateBorongChart();
    });
</script>
@endsection
