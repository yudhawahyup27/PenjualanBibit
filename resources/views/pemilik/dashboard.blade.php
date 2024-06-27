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
                        <option value="">All</option>
                        @foreach($transactionsPerYearEceran as $yearData)
                            <option value="{{ $yearData->year }}" {{ $selectedYear == $yearData->year ? 'selected' : '' }}>{{ $yearData->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterMonth" class="form-label">Select Month:</label>
                    <select class="form-select" id="filterMonth">
                        <option value="">All</option>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterDay" class="form-label">Select Day:</label>
                    <select class="form-select" id="filterDay">
                        <option value="">All</option>
                        @foreach(range(1, 31) as $day)
                            <option value="{{ $day }}" {{ $selectedDay == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5>Eceran Transactions</h5>
                    <canvas id="eceranChart"></canvas>
                </div>
                <div class="col-md-6">
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
    document.addEventListener('DOMContentLoaded', function() {
        var ctxEceran = document.getElementById('eceranChart').getContext('2d');
        var ctxBorong = document.getElementById('borongChart').getContext('2d');

        var transactionsPerDayEceran = @json($transactionsPerDayEceran);
        var transactionsPerMonthEceran = @json($transactionsPerMonthEceran);
        var transactionsPerYearEceran = @json($transactionsPerYearEceran);
        var transactionsPerDayBorong = @json($transactionsPerDayBorong);
        var transactionsPerMonthBorong = @json($transactionsPerMonthBorong);
        var transactionsPerYearBorong = @json($transactionsPerYearBorong);

        var selectedDay = {{ $selectedDay }};
        var selectedMonth = {{ $selectedMonth }};
        var selectedYear = {{ $selectedYear }};

        var labelsEceran, dataEceran, labelsBorong, dataBorong;

        // Default to daily view
        labelsEceran = transactionsPerDayEceran.map(item => item.day);
        dataEceran = transactionsPerDayEceran.map(item => item.total);
        labelsBorong = transactionsPerDayBorong.map(item => item.day);
        dataBorong = transactionsPerDayBorong.map(item => item.total);

        var eceranChart = new Chart(ctxEceran, {
            type: 'bar',
            data: {
                labels: labelsEceran,
                datasets: [{
                    label: 'Total Transactions (Eceran)',
                    data: dataEceran,
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

        var borongChart = new Chart(ctxBorong, {
            type: 'bar',
            data: {
                labels: labelsBorong,
                datasets: [{
                    label: 'Total Transactions (Borong)',
                    data: dataBorong,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
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
        function updateCharts() {
            var selectedYear = document.getElementById('filterYear').value;
            var selectedMonth = document.getElementById('filterMonth').value;
            var selectedDay = document.getElementById('filterDay').value;

            // Filter data based on selected filters
            var filteredDataEceran, filteredDataBorong;
            if (selectedDay) {
                filteredDataEceran = transactionsPerDayEceran.filter(item => item.day == selectedDay);
                filteredDataBorong = transactionsPerDayBorong.filter(item => item.day == selectedDay);
                labelsEceran = filteredDataEceran.map(item => item.day);
                dataEceran = filteredDataEceran.map(item => item.total);
                labelsBorong = filteredDataBorong.map(item => item.day);
                dataBorong = filteredDataBorong.map(item => item.total);
            } else if (selectedMonth) {
                filteredDataEceran = transactionsPerMonthEceran.filter(item => item.month == selectedMonth);
                filteredDataBorong = transactionsPerMonthBorong.filter(item => item.month == selectedMonth);
                labelsEceran = filteredDataEceran.map(item => item.month);
                dataEceran = filteredDataEceran.map(item => item.total);
                labelsBorong = filteredDataBorong.map(item => item.month);
                dataBorong = filteredDataBorong.map(item => item.total);
            } else {
                filteredDataEceran = transactionsPerYearEceran;
                filteredDataBorong = transactionsPerYearBorong;
                labelsEceran = filteredDataEceran.map(item => item.year);
                dataEceran = filteredDataEceran.map(item => item.total);
                labelsBorong = filteredDataBorong.map(item => item.year);
                dataBorong = filteredDataBorong.map(item => item.total);
            }

            // Update eceran chart data
            eceranChart.data.labels = labelsEceran;
            eceranChart.data.datasets[0].data = dataEceran;
            eceranChart.update();

            // Update borong chart data
            borongChart.data.labels = labelsBorong;
            borongChart.data.datasets[0].data = dataBorong;
            borongChart.update();
        }

        // Event listeners for filter changes
        document.getElementById('filterYear').addEventListener('change', function() {
            updateCharts();
        });

        document.getElementById('filterMonth').addEventListener('change', function() {
            updateCharts();
        });

        document.getElementById('filterDay').addEventListener('change', function() {
            updateCharts();
        });

        // Initial chart rendering
        updateCharts();
    });
</script>
@endsection
