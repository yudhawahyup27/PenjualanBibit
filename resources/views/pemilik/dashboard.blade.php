@extends('pemilik_core.core')

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
                        <option value="all">All</option>
                        @foreach($transactionsPerYearEceran as $yearData)
                            <option value="{{ $yearData->first()->year }}" {{ $selectedYear == $yearData->first()->year ? 'selected' : '' }}>{{ $yearData->first()->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterMonth" class="form-label">Select Month:</label>
                    <select class="form-select" id="filterMonth">
                        <option value="all">All</option>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterDay" class="form-label">Select Day:</label>
                    <select class="form-select" id="filterDay">
                        <option value="all">All</option>
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

        var selectedDay = "{{ $selectedDay }}";
        var selectedMonth = "{{ $selectedMonth }}";
        var selectedYear = "{{ $selectedYear }}";

        var labelsEceran = [];
        var dataEceran = [];
        var labelsBorong = [];
        var dataBorong = [];

        function updateChartData() {
            var year = document.getElementById('filterYear').value;
            var month = document.getElementById('filterMonth').value;
            var day = document.getElementById('filterDay').value;

            labelsEceran = [];
            dataEceran = [];
            labelsBorong = [];
            dataBorong = [];

            if (day !== 'all') {
                labelsEceran = transactionsPerDayEceran[day] ? transactionsPerDayEceran[day].map(item => item.day) : [];
                dataEceran = transactionsPerDayEceran[day] ? transactionsPerDayEceran[day].map(item => item.total) : [];
                labelsBorong = transactionsPerDayBorong[day] ? transactionsPerDayBorong[day].map(item => item.day) : [];
                dataBorong = transactionsPerDayBorong[day] ? transactionsPerDayBorong[day].map(item => item.total) : [];
            } else if (month !== 'all') {
                labelsEceran = transactionsPerMonthEceran[month] ? transactionsPerMonthEceran[month].map(item => item.month) : [];
                dataEceran = transactionsPerMonthEceran[month] ? transactionsPerMonthEceran[month].map(item => item.total) : [];
                labelsBorong = transactionsPerMonthBorong[month] ? transactionsPerMonthBorong[month].map(item => item.month) : [];
                dataBorong = transactionsPerMonthBorong[month] ? transactionsPerMonthBorong[month].map(item => item.total) : [];
            } else if (year !== 'all') {
                labelsEceran = transactionsPerYearEceran[year] ? transactionsPerYearEceran[year].map(item => item.year) : [];
                dataEceran = transactionsPerYearEceran[year] ? transactionsPerYearEceran[year].map(item => item.total) : [];
                labelsBorong = transactionsPerYearBorong[year] ? transactionsPerYearBorong[year].map(item => item.year) : [];
                dataBorong = transactionsPerYearBorong[year] ? transactionsPerYearBorong[year].map(item => item.total) : [];
            } else {
                // Default case if no specific filter is selected
                labelsEceran = transactionsPerYearEceran.map(item => item.first().year);
                dataEceran = transactionsPerYearEceran.map(item => item.sum('total'));
                labelsBorong = transactionsPerYearBorong.map(item => item.first().year);
                dataBorong = transactionsPerYearBorong.map(item => item.sum('total'));
            }

            updateCharts();
        }

        function updateCharts() {
            eceranChart.data.labels = labelsEceran;
            eceranChart.data.datasets[0].data = dataEceran;
            eceranChart.update();

            borongChart.data.labels = labelsBorong;
            borongChart.data.datasets[0].data = dataBorong;
            borongChart.update();
        }

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

        document.getElementById('filterYear').addEventListener('change', updateChartData);
        document.getElementById('filterMonth').addEventListener('change', updateChartData);
        document.getElementById('filterDay').addEventListener('change', updateChartData);

        updateChartData();
    });
</script>
@endsection
