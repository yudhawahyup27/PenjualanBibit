@extends('pemilik_core.core')

@section('content')
<div class="content">
    <div class="card mx-4">
        <a class="btn btn-primary float-end w-4" href="/pemilik/dashboard22">Statik Penjualan Eceran</a>
        <div class="card-body">
            {{-- Filter borong --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="filterYearBorong" class="form-label">Select Year (Borong):</label>
                    <select class="form-select" id="filterYearBorong" name="year_borong">
                        <option value="all">All</option>
                        @foreach($transactionsPerYearBorong as $year => $transactions)
                            <option value="{{ $year }}" {{ $selectedYearBorong == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterMonthBorong" class="form-label">Select Month (Borong):</label>
                    <select class="form-select" id="filterMonthBorong" name="month_borong">
                        <option value="all">All</option>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $selectedMonthBorong == $month ? 'selected' : '' }}>{{ $monthNames[$month - 1] }}</option>
                        @endforeach
                    </select>
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
        const yearSelectBorong = document.getElementById('filterYearBorong');
        const monthSelectBorong = document.getElementById('filterMonthBorong');
        let borongChart;

        function updateBorongChart() {
            const selectedYear = yearSelectBorong.value;
            const selectedMonth = monthSelectBorong.value;

            fetch(`{{ route('dashboard2') }}?year_borong=${selectedYear}&month_borong=${selectedMonth}`, {
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

                    if (selectedYear === 'all') {
                        labels = data.transactions.map(transaction => new Date(transaction.created_at).getFullYear());
                    } else if (selectedMonth === 'all') {
                        labels = data.transactions.map(transaction => {
                            const date = new Date(transaction.created_at);
                            return `${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;
                        });
                    } else {
                        labels = data.transactions.map(transaction => {
                            const date = new Date(transaction.created_at);
                            return `${date.getDate()} ${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;
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

        yearSelectBorong.addEventListener('change', function() {
            updateBorongChart();
        });

        monthSelectBorong.addEventListener('change', updateBorongChart);

        updateBorongChart();
    });
</script>
@endsection
