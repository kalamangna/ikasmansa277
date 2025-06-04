<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Kunjungan</h1>
    
    <!-- Year Filter -->
    <div class="row mb-4">
        <div class="col-md-3">
            <form method="get" action="">
                <div class="form-group">
                    <label for="tahun">Pilih Tahun:</label>
                    <select class="form-control" id="tahun" name="tahun" onchange="this.form.submit()">
                        <?php foreach($available_years as $year): ?>
                            <option value="<?php echo $year->year; ?>" <?php echo ($year->year == $selected_year) ? 'selected' : ''; ?>>
                                <?php echo $year->year; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <!-- Total Visits Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_visits); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unique Visits Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kunjungan Unik</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($unique_visits); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Comparison Chart -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Perbandingan Bulanan Tahun <?php echo $selected_year; ?></h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="monthlyComparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- OS and Browser Comparison -->
    <div class="row">
        <!-- OS Stats -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Sistem Operasi (<?php echo $selected_year; ?>)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="osStatsChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <?php foreach($os_stats as $os): ?>
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: <?php echo $this->Counter_model->get_chart_color($os->os); ?>"></i> 
                                <?php echo $os->os; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Browser Stats -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Browser (<?php echo $selected_year; ?>)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="browserStatsChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <?php foreach($browser_stats as $browser): ?>
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: <?php echo $this->Counter_model->get_chart_color($browser->browser); ?>"></i> 
                                <?php echo $browser->browser; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Stats Chart -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Harian (30 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="dailyStatsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Visits Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kunjungan Terakhir</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>IP Address</th>
                            <th>Halaman</th>
                            <th>User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recent_visits as $visit): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($visit->created_at)); ?></td>
                            <td><?php echo $visit->ip_address; ?></td>
                            <td><?php echo $visit->page_visited; ?></td>
                            <td><?php echo substr($visit->user_agent, 0, 50); ?>...</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Top Pages Section -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">10 Halaman Terpopuler (<?php echo $selected_year; ?>)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Halaman</th>
                                <th>Jumlah Kunjungan</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Hitung total kunjungan untuk tahun ini
                            $total_visits_year = 0;
                            foreach($monthly_stats as $month) {
                                $total_visits_year += $month->total;
                            }
                            
                            $counter = 1;
                            foreach($top_pages as $page): 
                                $percentage = ($total_visits_year > 0) ? round(($page->visit_count / $total_visits_year) * 100, 2) : 0;
                            ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo substr($page->page_visited, 0, 50); ?><?php echo strlen($page->page_visited) > 50 ? '...' : ''; ?></td>
                                <td><?php echo number_format($page->visit_count); ?></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%" 
                                            aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $percentage; ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page level plugins -->
<!-- <script src="<?php echo base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script> -->
<script src="<?= base_url('assets/sb_admin/vendor/chart.js/Chart.min.js') ?>"></script>

<script>
// Function to generate dynamic colors
function dynamicColors() {
    var colors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', 
        '#858796', '#5a5c69', '#3a3b45', '#2e59d9', '#17a673',
        '#2c9faf', '#dda20a', '#be2617', '#6c757d', '#5a6268'
    ];
    return colors;
}

// Monthly Comparison Chart
var ctxMonthly = document.getElementById("monthlyComparisonChart");
var monthlyComparisonChart = new Chart(ctxMonthly, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
            label: "Total Kunjungan",
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: [
                <?php 
                $monthly_data = array_fill(0, 12, 0);
                foreach($monthly_stats as $stat) {
                    $monthly_data[$stat->month-1] = $stat->total;
                }
                echo implode(',', $monthly_data);
                ?>
            ],
        }, {
            label: "Kunjungan Unik",
            backgroundColor: "#1cc88a",
            hoverBackgroundColor: "#17a673",
            borderColor: "#1cc88a",
            data: [
                <?php 
                $monthly_unique = array_fill(0, 12, 0);
                foreach($monthly_stats as $stat) {
                    $monthly_unique[$stat->month-1] = $stat->unique;
                }
                echo implode(',', $monthly_unique);
                ?>
            ],
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                maxBarThickness: 25,
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    padding: 10,
                    callback: function(value, index, values) {
                        return value.toLocaleString();
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: true
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel.toLocaleString();
                }
            }
        },
    }
});

// OS Stats Chart
var ctxOS = document.getElementById("osStatsChart");
var osStatsChart = new Chart(ctxOS, {
    type: 'doughnut',
    data: {
        labels: [
            <?php 
            $os_labels = array();
            foreach($os_stats as $os) {
                $os_labels[] = "'".$os->os."'";
            }
            echo implode(',', $os_labels);
            ?>
        ],
        datasets: [{
            data: [
                <?php 
                $os_data = array();
                foreach($os_stats as $os) {
                    $os_data[] = $os->count;
                }
                echo implode(',', $os_data);
                ?>
            ],
            backgroundColor: [
                <?php 
                $os_colors = array();
                foreach($os_stats as $os) {
                    $os_colors[] = "'".$this->Counter_model->get_chart_color($os->os)."'";
                }
                echo implode(',', $os_colors);
                ?>
            ],
            hoverBackgroundColor: dynamicColors(),
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.data.labels[tooltipItem.index] || '';
                    var value = chart.data.datasets[0].data[tooltipItem.index];
                    var total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    var percentage = Math.round((value / total) * 100);
                    return datasetLabel + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                }
            }
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});

// Browser Stats Chart
var ctxBrowser = document.getElementById("browserStatsChart");
var browserStatsChart = new Chart(ctxBrowser, {
    type: 'doughnut',
    data: {
        labels: [
            <?php 
            $browser_labels = array();
            foreach($browser_stats as $browser) {
                $browser_labels[] = "'".$browser->browser."'";
            }
            echo implode(',', $browser_labels);
            ?>
        ],
        datasets: [{
            data: [
                <?php 
                $browser_data = array();
                foreach($browser_stats as $browser) {
                    $browser_data[] = $browser->count;
                }
                echo implode(',', $browser_data);
                ?>
            ],
            backgroundColor: [
                <?php 
                $browser_colors = array();
                foreach($browser_stats as $browser) {
                    $browser_colors[] = "'".$this->Counter_model->get_chart_color($browser->browser)."'";
                }
                echo implode(',', $browser_colors);
                ?>
            ],
            hoverBackgroundColor: dynamicColors(),
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.data.labels[tooltipItem.index] || '';
                    var value = chart.data.datasets[0].data[tooltipItem.index];
                    var total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    var percentage = Math.round((value / total) * 100);
                    return datasetLabel + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                }
            }
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});

// Daily Stats Chart
var ctxDaily = document.getElementById("dailyStatsChart");
var dailyStatsChart = new Chart(ctxDaily, {
    type: 'line',
    data: {
        labels: [
            <?php 
            $labels = array();
            foreach(array_reverse($daily_stats) as $stat) {
                $labels[] = "'".date('d M', strtotime($stat->visit_date))."'";
            }
            echo implode(',', $labels);
            ?>
        ],
        datasets: [{
            label: "Total Kunjungan",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [
                <?php 
                $data = array();
                foreach(array_reverse($daily_stats) as $stat) {
                    $data[] = $stat->total_visits;
                }
                echo implode(',', $data);
                ?>
            ],
        },{
            label: "Kunjungan Unik",
            lineTension: 0.3,
            backgroundColor: "rgba(28, 200, 138, 0.05)",
            borderColor: "rgba(28, 200, 138, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(28, 200, 138, 1)",
            pointBorderColor: "rgba(28, 200, 138, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
            pointHoverBorderColor: "rgba(28, 200, 138, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [
                <?php 
                $data = array();
                foreach(array_reverse($daily_stats) as $stat) {
                    $data[] = $stat->unique_visits;
                }
                echo implode(',', $data);
                ?>
            ],
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value, index, values) {
                        return value.toLocaleString();
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: true
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel.toLocaleString();
                }
            }
        }
    }
});
</script>