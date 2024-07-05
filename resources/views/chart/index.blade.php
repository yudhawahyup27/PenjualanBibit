@extends('pemilik_core.core')

@section('content')
    <div>
        <form id="filterForm">
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" value="{{ \Carbon\Carbon::now()->year }}">

            <label for="month">Month:</label>
            <input type="number" id="month" name="month">

            <label for="day">Day:</label>
            <input type="number" id="day" name="day">

            <button type="submit">Filter</button>
        </form>
    </div>

    <canvas id="transactionChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetchChartData();
        });

        function fetchChartData() {
            let year = document.getElementById('year').value;
            let month = document.getElementById('month').value;
            let day = document.getElementById('day').value;

            fetch(`/chart-data?year=${year}&month=${month}&day=${day}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let labels = data.map(transaction => new Date(transaction.created_at).toLocaleDateString());
                    let values = data.map(transaction => transaction.total_transaksi);

                    let ctx = document.getElementById('transactionChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Transaksi',
                                data: values,
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
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        // Fetch initial chart data
        fetchChartData();
    </script>
@endsection
