@extends('pemilik_core/core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Dashboard Data
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <label for="filterYear" class="form-label">Select Year:</label>
                    <select class="form-select" id="filterYear">
                        @foreach($transactionsPerYear as $yearData)
                            <option value="{{ $yearData->year }}" {{ $selectedYear == $yearData->year ? 'selected' : '' }}>{{ $yearData->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterMonth" class="form-label">Select Month:</label>
                    <select class="form-select" id="filterMonth">
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterDay" class="form-label">Select Day:</label>
                    <select class="form-select" id="filterDay">
                        @foreach($transactionsPerDay as $dayData)
                            <option value="{{ $dayData->day }}" {{ $selectedDay == $dayData->day ? 'selected' : '' }}>{{ $dayData->day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <canvas id="transactionChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('transactionChart').getContext('2d');

            var transactionsPerDay = @json($transactionsPerDay);
            var transactionsPerMonth = @json($transactionsPerMonth);
            var transactionsPerYear = @json($transactionsPerYear);

            var selectedDay = {{ $selectedDay }};
            var selectedMonth = {{ $selectedMonth }};
            var selectedYear = {{ $selectedYear }};

            var labels, data;

            // Default to daily view
            labels = transactionsPerDay.map(item => item.day);
            data = transactionsPerDay.map(item => item.total);

            var transactionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Transactions',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Function to update chart based on selected filters
            function updateChart() {
                var selectedYear = document.getElementById('filterYear').value;
                var selectedMonth = document.getElementById('filterMonth').value;
                var selectedDay = document.getElementById('filterDay').value;

                // Filter data based on selected filters
                var filteredData;
                if (selectedDay) {
                    filteredData = transactionsPerDay.filter(item => item.day == selectedDay);
                    labels = filteredData.map(item => item.day);
                    data = filteredData.map(item => item.total);
                } else if (selectedMonth) {
                    filteredData = transactionsPerMonth.filter(item => item.month == selectedMonth);
                    labels = filteredData.map(item => item.month);
                    data = filteredData.map(item => item.total);
                } else {
                    filteredData = transactionsPerYear;
                    labels = filteredData.map(item => item.year);
                    data = filteredData.map(item => item.total);
                }

                // Update chart data
                transactionChart.data.labels = labels;
                transactionChart.data.datasets[0].data = data;
                transactionChart.update();
            }

            // Event listeners for filter changes
            document.getElementById('filterYear').addEventListener('change', function() {
                updateChart();
            });

            document.getElementById('filterMonth').addEventListener('change', function() {
                updateChart();
            });

            document.getElementById('filterDay').addEventListener('change', function() {
                updateChart();
            });

            // Initial chart rendering
            updateChart();
        });
    </script>
@endsection
