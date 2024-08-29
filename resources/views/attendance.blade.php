@extends($layout)

@section('content')


<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-doughnutlabel@1.0.1/dist/chartjs-plugin-doughnutlabel.min.js"></script>

    
<main id="main" class="main">
    <div class="pagetitle">
        <h1><center>Attendance</center></h1>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <div class="col-lg-10">
                </br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total number of students :<strong> {{$totalstud}}</strong></h5>
                        <canvas id="doughnutChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#doughnutChart'), {
                                    type: 'doughnut',
                                    data: {
                                    labels: [
                                        'Present',
                                        'Partial Present',
                                        'Absent'
                                    ],
                                    datasets: [{
                                        label: '',
                                        data: [{{$present}},{{$partialPresent}},{{$totalabsent}}],
                                        backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)'
                                        ],
                                        hoverOffset: 4
                                    }]
                                    }
                                });
                                });
                            </script>
                    </div>
                </div>
            </div>
            <!-- Button to download CSV -->
             <a href="{{ route('downloadcsvforatten') }}" class="btn btn-outline-secondary">Download CSV</a>

        </div>
    </div>

@endsection