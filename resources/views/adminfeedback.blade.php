@extends('layouts.admin')
@section('content')
<style>
    .outstanding {
        background-color: #4fb353; 
        color: white;
        padding: 10px;
        border-radius: 5px;
        width: 90%;
    }

    .excellent {
        background-color: #c6fc86; 
        color: white;
        padding: 10px;
        border-radius: 5px;
        width: 90%;
    }

    .very-good {
        background-color: #ebfc3a; 
        color: black;
        padding: 10px;
        border-radius: 5px;
        width: 90%;
    }

    .good {
        background-color: #fcfa7e; 
        color: black;
        padding: 10px;
        border-radius: 5px;
        width: 90%;
    }

    .average {
        background-color: #fcc4a2; 
        color: black;
        padding: 10px;
        border-radius: 5px;
        width: 90%;
    }

    .poor {
        background-color: #f7b7b7; 
        color: white;
        padding: 10px;
        border-radius: 5px;
        width: 90%;
    }

    .below-minimum {
        background-color: #F44336;
        color: white;
        padding: 10px;
        border-radius: 5px;
        width: 90%;
    }

    .card-bodycat {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .chart-container {
        flex: 1;
        margin-right: 10px; /* Space between chart and categorization */
    }

    .categorization-container {
        flex: 1;
    }
    .result{
        
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Feedback</h1>
    </div>
    <ul>
</ul>
    
    <!-- Single Card Containing Both Sections -->
    <div class="card">
        <div class="card-bodycat">
            <!-- Radial Bar Chart Section -->
            <div class="chart-container">
                <h5 class="card-title"><strong> <center>Radial Bar Chart - Understanding, Overall Experience and Difficulty Level</center></strong></h5>
                <div id="radialBarChart"></div>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        new ApexCharts(document.querySelector("#radialBarChart"), {
                            series: [{{$averagedifficulty}}, {{$averageoverall}}, {{$average}}],
                            chart: {
                                height: 350,
                                type: 'radialBar',
                                toolbar: {
                                    show: true
                                }
                            },
                            plotOptions: {
                                radialBar: {
                                    dataLabels: {
                                        name: {
                                            fontSize: '22px',
                                        },
                                        value: {
                                            fontSize: '16px',
                                        },
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            formatter: function(w) {
                                                return {{$totalcount}};
                                            }
                                        }
                                    }
                                }
                            },
                            labels: ['Difficulty Level', 'Overall Experience', 'Understanding'],
                        }).render();
                    });
                </script>
            </div>

            <!-- Categorization Section -->
            <div class="categorization-container">
                <h5 class="card-title"><center>Categorization</center></h5>
                <?php
                    function categorize($value) {
                        if ($value >= 90) {
                            return 'outstanding';
                        } elseif ($value >= 80) {
                            return 'excellent';
                        } elseif ($value >= 70) {
                            return 'very-good';
                        } elseif ($value >= 60) {
                            return 'good';
                        } elseif ($value >= 50) {
                            return 'average';
                        } elseif ($value >= 40) {
                            return 'poor';
                        } else {
                            return 'below-minimum';
                        }
                    }
                ?>
                <div class="result">
                    <center><p class="{{ categorize($average) }}">Understanding: {{ categorize($average) }}</p></center>
                    <center><p class="{{ categorize($averageoverall) }}">Overall Experience: {{ categorize($averageoverall) }}</p></center>
                    <center><p class="{{ categorize($averagedifficulty) }}">Difficulty Level: {{ categorize($averagedifficulty) }}</p></center>
                </div>
            </div>
        </div>
    </div>
<div class="col-lg-6">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Lab Confusion</h5>
              <div id="pieChart"></div>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#pieChart"), {
                    series: [{{$negativecount}},{{$positivecount}}],
                    chart: {
                      height: 350,
                      type: 'pie',
                      toolbar: {
                        show: true
                      }
                    },
                    labels: ['True', 'False']
                  }).render();
                });
              </script>
              <!-- End Pie Chart -->

            </div>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bubble Chart</h5>
              <div id="bubbleChart"></div>
                <button id="downloadCsv" type="button" class="btn btn-outline-secondary">Download CSV</button>
                  <script>
                      document.addEventListener("DOMContentLoaded", () => {
                        const interestingData = @json($interesting);
                        const engagingData = @json($engaging);
                        const importantData = @json($important);
                        const confusingData = @json($confusing);
                        function generateData(data) 
                        {
                          const series = [];
                            for (const [word, count] of Object.entries(data)) 
                            {
                              const x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;
                              const y = Math.floor(Math.random() * (60 - 10 + 1)) + 10;
                              const z = count;
                              series.push(
                                {
                                    x: x,
                                    y: y,
                                    z: z,
                                    label: word
                                });
                            }
                              return series;
                        }
                        new ApexCharts(document.querySelector("#bubbleChart"), {
                          series: [
                            {
                              name: 'Interesting',
                              data: generateData(interestingData)
                            },
                            {
                              name: 'Engaging',
                              data: generateData(engagingData)
                            },
                            {
                              name: 'Important',
                              data: generateData(importantData)
                            },
                            {
                              name: 'Confusing',
                              data: generateData(confusingData)
                            }
                          ],
                          chart: {
                            height: 333,
                            type: 'bubble',
                            toolbar: {
                              tools: {
                                download: false, // Hide the download menu
                                selection: true,
                                zoom: true,
                                zoomin: true,
                                zoomout: true,
                                pan: true,
                                reset: true,
                              }
                            }
                          },
                          dataLabels: {
                            enabled: false
                          },
                          fill: {
                            opacity: 0.8,
                            colors: ['#0000FF', '#00FF00', '#FFFF00', '#FF0000'] // Colors for different series
                          },
                          xaxis: {
                            tickAmount: 12,
                            type: 'category',
                          },
                          yaxis: {
                            max: 70
                          },
                          tooltip: {
                            y: {
                              formatter: function (val, opts) {
                                const word = opts.w.config.series[opts.seriesIndex].data[opts.dataPointIndex]?.label || '';
                                const count = opts.w.config.series[opts.seriesIndex].data[opts.dataPointIndex]?.z || val;
                                return `${word}\nCount: ${count}`;
                              }
                            }
                          }
                      }).render();
                    function downloadCSV() {
                      let csvContent = "data:text/csv;charset=utf-8,";
                      csvContent += "Activities you find most interesting,Things to make the class more engaging, Important thing you learned today, Anything that was confusing or unclear\n";
                      const maxLength = Math.max(
                        Object.keys(interestingData).length,
                        Object.keys(engagingData).length,
                        Object.keys(importantData).length,
                        Object.keys(confusingData).length
                      );
                      for (let i = 0; i < maxLength; i++) {
                        const interestingWord = Object.keys(interestingData)[i] || '';
                        const interestingCount = interestingData[interestingWord] || '';
                        
                        const engagingWord = Object.keys(engagingData)[i] || '';
                        const engagingCount = engagingData[engagingWord] || '';

                        const importantWord = Object.keys(importantData)[i] || '';
                        const importantCount = importantData[importantWord] || '';

                        const confusingWord = Object.keys(confusingData)[i] || '';
                        const confusingCount = confusingData[confusingWord] || '';

                        csvContent += `${interestingWord} (${interestingCount}),${engagingWord} (${engagingCount}),${importantWord} (${importantCount}),${confusingWord} (${confusingCount})\n`;
                      }
                      const encodedUri = encodeURI(csvContent);
                      const link = document.createElement("a");
                      link.setAttribute("href", encodedUri);
                      link.setAttribute("download", "bubble_chart_data.csv");
                      document.body.appendChild(link);
                      link.click();
                      document.body.removeChild(link);
                    }
                    document.getElementById("downloadCsv").addEventListener("click", downloadCSV);
                    });
                  </script>
            </div>
          </div>
        </div>


</main>
@endsection
    