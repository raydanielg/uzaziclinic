@extends('layouts.admin')

@section('page_title', 'Analytics Dashboard')

@push('css')
    <!-- Additional Styles for Apex Charts -->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="row">
    <div class="col-lg-6 animate__animated animate__fadeInLeft">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h4 class="card-title mb-4">Patient Admission Trend</h4>
            <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
    <div class="col-lg-6 animate__animated animate__fadeInRight">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h4 class="card-title mb-4">Department Revenue Distribution</h4>
            <div id="column_chart" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 animate__animated animate__fadeInUp">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h4 class="card-title mb-4">Hospital Bed Occupancy</h4>
            <div id="bar_chart" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
    <div class="col-lg-6 animate__animated animate__fadeInUp">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h4 class="card-title mb-4">Patient Satisfaction Index</h4>
            <div id="mixed_chart" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 animate__animated animate__fadeInUp">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h4 class="card-title mb-4">Patient Age Groups</h4>
            <div id="radial_chart" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
    <div class="col-lg-6 animate__animated animate__fadeInUp">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h4 class="card-title mb-4">Emergency vs Routine Visits</h4>
            <div id="pie_chart" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Apex Charts JS -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        // Patient Admission Trend (Line Chart with Data Labels)
        var options = {
            chart: { height: 380, type: 'line', zoom: { enabled: false }, toolbar: { show: false } },
            colors: ['#365cf5', '#10b981'],
            dataLabels: { enabled: true },
            stroke: { width: [3, 3], curve: 'straight' },
            series: [
                { name: "Male Patients", data: [28, 29, 33, 36, 32, 32, 33] },
                { name: "Female Patients", data: [12, 11, 14, 18, 17, 13, 13] }
            ],
            title: { text: 'Daily Admissions', align: 'left', style: { fontWeight: '500' } },
            grid: { row: { colors: ['transparent', 'transparent'], opacity: 0.5 }, borderColor: '#f1f1f1' },
            markers: { style: 'inverted', size: 6 },
            xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'], title: { text: 'Month' } },
            yaxis: { title: { text: 'Count' }, min: 5, max: 40 },
            legend: { position: 'top', horizontalAlign: 'right', floating: true, offsetTop: -25, offsetLeft: -5 }
        };
        var chart = new Chart(document.querySelector("#line_chart_datalabel"), options);
        chart.render();

        // Department Revenue Distribution (Column Chart)
        var options = {
            chart: { height: 350, type: 'bar', toolbar: { show: false } },
            plotOptions: { bar: { horizontal: false, columnWidth: '45%', endingShape: 'rounded' } },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            series: [
                { name: 'Revenue', data: [46, 57, 59, 54, 62, 58, 63, 60, 66] },
                { name: 'Expenses', data: [74, 83, 102, 97, 86, 106, 93, 114, 94] }
            ],
            xaxis: { categories: ['Maternity', 'Pediatrics', 'Dental', 'Lab', 'Pharmacy', 'General', 'ICU', 'Radiology', 'Surgery'] },
            yaxis: { title: { text: 'TSh (Millions)' } },
            fill: { opacity: 1 },
            colors: ['#365cf5', '#f1f1f1'],
            tooltip: { y: { formatter: function (val) { return "TSh " + val + " Millions" } } }
        };
        var chart = new Chart(document.querySelector("#column_chart"), options);
        chart.render();

        // Hospital Bed Occupancy (Bar Chart)
        var options = {
            chart: { height: 350, type: 'bar', toolbar: { show: false } },
            plotOptions: { bar: { horizontal: true } },
            dataLabels: { enabled: false },
            series: [{ data: [380, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380] }],
            colors: ['#10b981'],
            xaxis: { categories: ['ICU', 'General Ward', 'Maternity', 'Pediatrics', 'Surgery', 'Dental', 'Radiology', 'Emergency', 'VIP Ward', 'Total Beds'] }
        };
        var chart = new Chart(document.querySelector("#bar_chart"), options);
        chart.render();

        // Patient Satisfaction Index (Mixed Chart)
        var options = {
            chart: { height: 350, type: 'line', toolbar: { show: false } },
            series: [
                { name: 'Patient Feedback', type: 'column', data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30] },
                { name: 'Satisfaction Score', type: 'area', data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43] },
                { name: 'Admin Response', type: 'line', data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39] }
            ],
            stroke: { width: [0, 2, 5], curve: 'smooth' },
            plotOptions: { bar: { columnWidth: '50%' } },
            fill: { opacity: [0.85, 0.25, 1], gradient: { inverseColors: false, shade: 'light', type: "vertical", opacityFrom: 0.85, opacityTo: 0.55, stops: [0, 100, 100, 100] } },
            labels: ['01/01/2026', '02/01/2026', '03/01/2026', '04/01/2026', '05/01/2026', '06/01/2026', '07/01/2026', '08/01/2026', '09/01/2026', '10/01/2026', '11/01/2026'],
            markers: { size: 0 },
            xaxis: { type: 'datetime' },
            yaxis: { title: { text: 'Score' } },
            tooltip: { shared: true, intersect: false, y: { formatter: function (y) { if (typeof y !== "undefined") { return y.toFixed(0) + " points"; } return y; } } },
            colors: ['#365cf5', '#10b981', '#f59e0b']
        };
        var chart = new Chart(document.querySelector("#mixed_chart"), options);
        chart.render();

        // Patient Age Groups (Radial Chart)
        var options = {
            chart: { height: 370, type: 'radialBar' },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: { fontSize: '22px' },
                        value: { fontSize: '16px' },
                        total: { show: true, label: 'Average Age', formatter: function (w) { return 42 } }
                    }
                }
            },
            series: [44, 55, 67, 83],
            labels: ['0-18 Years', '19-40 Years', '41-60 Years', '60+ Years'],
            colors: ['#365cf5', '#10b981', '#f59e0b', '#ef4444']
        };
        var chart = new Chart(document.querySelector("#radial_chart"), options);
        chart.render();

        // Emergency vs Routine Visits (Pie Chart)
        var options = {
            chart: { height: 320, type: 'pie' },
            series: [44, 55, 13, 33],
            labels: ['Emergency', 'Routine Checkup', 'Follow-up', 'Specialist Consultation'],
            colors: ["#365cf5", "#10b981", "#ebeff2", "#f59e0b"],
            legend: { show: true, position: 'bottom', horizontalAlign: 'center', verticalAlign: 'middle', floating: false, fontSize: '14px', offsetX: 0 },
            responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: false } } }]
        };
        var chart = new Chart(document.querySelector("#pie_chart"), options);
        chart.render();
    </script>
@endpush
