@extends('pemilik_core.core')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            Dashboard Data (Eceran)
        </div>
        <div class="card-body">
            {{-- Filter eceran --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="filterYearEceran" class="form-label">Select Year (Eceran):</label>
                    <select class="form-select" id="filterYearEceran">
                        <option value="all">All</option>
                        @foreach($transactionsPerYearEceran as $yearData)
                            <option value="{{ $yearData['year'] }}" {{ $selectedYearEceran == $yearData['year'] ? 'selected' : '' }}>{{ $yearData['year'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterMonthEceran" class="form-label">Select Month (Eceran):</label>
                    <select class="form-select" id="filterMonthEceran">
                        <option value="all">All</option>
                        @foreach($transactionsPerMonthEceran as $monthYear => $monthData)
                            @php
                                $monthYearArray = explode('-', $monthYear);
                                $month = $monthYearArray[0];
                                $year = $monthYearArray[1];
                            @endphp
                            <option value="{{ $month }}" data-year="{{ $year }}" {{ $selectedMonthEceran == $month && $selectedYearEceran == $year ? 'selected' : '' }}>{{ $monthNames[$month - 1] }}</option>
                        @endforeach
                    </select>
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

    <div class="card mb-4">
        <div class="card-header">
            Dashboard Data (Borong)
        </div>
        <div class="card-body">
            {{-- Filter borong --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="filterYearBorong" class="form-label">Select Year (Borong):</label>
                    <select class="form-select" id="filterYearBorong">
                        <option value="all">All</option>
                        @foreach($transactionsPerYearBorong as $yearData)
                            <option value="{{ $yearData['year'] }}" {{ $selectedYearBorong == $yearData['year'] ? 'selected' : '' }}>{{ $yearData['year'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="filterMonthBorong" class="form-label">Select Month (Borong):</label>
                    <select class="form-select" id="filterMonthBorong">
                        <option value="all">All</option>
                        @foreach($transactionsPerMonthBorong as $monthYear => $monthData)
                            @php
                                $monthYearArray = explode('-', $monthYear);
                                $month = $monthYearArray[0];
                                $year = $monthYearArray[1];
                            @endphp
                            <option value="{{ $month }}" data-year="{{ $year }}" {{ $selectedMonthBorong == $month && $selectedYearBorong == $year ? 'selected' : '' }}>{{ $monthNames[$month - 1] }}</option>
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
    document.addEventListener('DOMContentLoaded', function() {
        var ctxEceran = document.getElementById('eceranChart').getContext('2d');
        var ctxBorong = document.getElementById('borongChart').getContext('2d');

        var transactionsPerMonthEceran = @json($transactionsPerMonthEceran);
        var transactionsPerYearEceran = @json($transactionsPerYearEceran);
        var transactionsPerMonthBorong = @json($transactionsPerMonthBorong);
        var transactionsPerYearBorong = @json($transactionsPerYearBorong);

        var selectedMonthEceran = "{{ $selectedMonthEceran }}";
        var selectedYearEceran = "{{ $selectedYearEceran }}";
        var selectedMonthBorong = "{{ $selectedMonthBorong }}";
        var selectedYearBorong = "{{ $selectedYearBorong }}";

        var labelsEceran = [];
        var dataEceran = [];
        var labelsBorong = [];
        var dataBorong = [];

        // Array of month names
        var monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        function updateEceranChartData() {
            var year = document.getElementById('filterYearEceran').value;
            var month = document.getElementById('filterMonthEceran').value;

            labelsEceran = [];
            dataEceran = [];

            if (month !== 'all') {
                labelsEceran = transactionsPerMonthEceran[`${month}-${year}`] ? transactionsPerMonthEceran[`${month}-${year}`].map(item => item.day) : [];
                dataEceran = transactionsPerMonthEceran[month + '-' + year] ? transactionsPerMonthEceran[month + '-' + year].map(item => item.total) : [];
            } else if (year !== 'all') {
                labelsEceran = [];
                dataEceran = [];

                for (var i = 1; i <= 12; i++) {
                    var totalEceran = 0;
                    transactionsPerMonthEceran[i + '-' + year] ? transactionsPerMonthEceran[i + '-' + year].forEach(function(item) {
                        totalEceran += item.total;
                    }) : 0;

                    if (totalEceran > 0) {
                        labelsEceran.push(monthNames[i - 1]); // Convert month number to month name
                        dataEceran.push(totalEceran);
                    }
                }
            } else {
                labelsEceran = transactionsPerYearEceran.map(item => item.year);
                dataEceran = transactionsPerYearEceran.map(item => item.total);
            }

            updateEceranChart();
        }

        function updateBorongChartData() {
            var year = document.getElementById('filterYearBorong').value;
            var month = document.getElementById('filterMonthBorong').value;

            labelsBorong = [];
            dataBorong = [];

            if (month !== 'all') {

                labelsBorong = transactionsPerMonthBorong[`${month}-${year}`]  ? transactionsPerMonthBorong[`${month}-${year}`].map(item => item.day) : [];
                dataBorong = transactionsPerMonthBorong[month + '-' + year] ? transactionsPerMonthBorong[month + '-' + year].map(item => item.total) : [];
            } else if (year !== 'all') {
                labelsBorong = [];
                dataBorong = [];

                for (var i = 1; i <= 12; i++) {
                    var totalBorong = 0;
                    transactionsPerMonthBorong[i + '-' + year] ? transactionsPerMonthBorong[i + '-' + year].forEach(function(item) {
                        totalBorong += item.total;
                    }) : 0;

                    if (totalBorong > 0) {
                        labelsBorong.push(monthNames[i - 1]); // Convert month number to month name
                        dataBorong.push(totalBorong);
                    }
                }
            } else {
                labelsBorong = transactionsPerYearBorong.map(item => item.year);
                dataBorong = transactionsPerYearBorong.map(item => item.total);
            }

            updateBorongChart();
        }

        function updateEceranChart() {
            eceranChart.data.labels = labelsEceran;
            eceranChart.data.datasets[0].data = dataEceran;
            eceranChart.update();
        }

        function updateBorongChart() {
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

        document.getElementById('filterYearEceran').addEventListener('change', updateEceranChartData);
        document.getElementById('filterMonthEceran').addEventListener('change', updateEceranChartData);
        document.getElementById('filterYearBorong').addEventListener('change', updateBorongChartData);
        document.getElementById('filterMonthBorong').addEventListener('change', updateBorongChartData);

        updateEceranChartData();
        updateBorongChartData();
    });

</script>
@endsection
