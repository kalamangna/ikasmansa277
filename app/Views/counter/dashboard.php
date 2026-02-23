<div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-y-6">
  <div>
    <h1 class="text-3xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">Traffic</h1>
    <p class="text-sm text-slate-400 font-bold mt-2 uppercase tracking-widest leading-none">Analitik Kunjungan</p>
  </div>

  <form method="get" class="flex items-center gap-x-4">
    <label for="tahun" class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] italic">Tahun</label>
    <div class="relative group">
      <select id="tahun" name="tahun" onchange="this.form.submit()" class="appearance-none rounded-xl border-slate-200 py-2.5 pl-5 pr-12 text-sm font-black text-blue-900 focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 bg-white shadow-sm transition-all cursor-pointer uppercase">
        <?php foreach ($available_years as $year): ?>
          <option value="<?php echo $year->year; ?>" <?php echo ($year->year == $selected_year) ? 'selected' : ''; ?>>Tahun <?php echo $year->year; ?></option>
        <?php endforeach; ?>
      </select>
      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-hover:text-blue-900 transition-colors">
        <i class="fa fa-chevron-down text-[10px]"></i>
      </div>
    </div>
  </form>
</div>

<!-- Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
  <div class="bg-blue-900 p-6 rounded-[2rem] shadow-xl border-b-8 border-blue-950 relative overflow-hidden group">
    <div class="absolute -right-4 -bottom-4 opacity-10"><i class="fa fa-chart-line text-8xl text-white italic"></i></div>
    <div class="flex items-center gap-x-3 mb-8 relative z-10">
      <div class="p-2 bg-white/10 rounded-xl backdrop-blur-md ring-1 ring-white/20"><i class="fa fa-globe text-yellow-400"></i></div>
      <span class="text-[9px] font-black text-blue-100 uppercase tracking-widest">Traffic</span>
    </div>
    <div class="mt-auto relative z-10">
      <p class="text-4xl font-black text-white tabular-nums tracking-tighter italic leading-none"><?php echo $total_visits; ?></p>
      <p class="text-[9px] font-bold text-blue-300 uppercase tracking-[0.3em] mt-3">Total Kunjungan</p>
    </div>
  </div>

  <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-slate-200 border-b-8 border-slate-100 flex flex-col group hover:border-blue-900 transition-all">
    <div class="flex items-center gap-x-3 mb-8">
      <div class="p-2 bg-blue-50 rounded-xl group-hover:bg-blue-900 transition-colors shadow-inner"><i class="fa fa-fingerprint text-blue-900 group-hover:text-yellow-400"></i></div>
      <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Unique</span>
    </div>
    <div class="mt-auto">
      <p class="text-4xl font-black text-slate-800 tabular-nums tracking-tighter group-hover:text-blue-900 transition-colors leading-none"><?php echo $unique_visits; ?></p>
      <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-3 italic">User Unik</p>
    </div>
  </div>
</div>

<!-- Timeline Chart -->
<div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden mb-12">
  <div class="px-10 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
    <h3 class="text-xs font-black text-blue-900 uppercase tracking-[0.3em] italic">Statistik Bulanan (<?= $selected_year ?>)</h3>
    <i class="fa fa-chart-area text-slate-200"></i>
  </div>
  <div class="p-10">
    <div id="apexMonthly" class="w-full"></div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-12">
  <!-- OS -->
  <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">
    <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between">
      <h3 class="text-xs font-black text-blue-900 uppercase tracking-[0.2em] italic">OS</h3>
      <i class="fa fa-laptop-code text-slate-200"></i>
    </div>
    <div class="p-8 flex-1 flex items-center justify-center min-h-[350px]">
      <div id="apexOS" class="w-full"></div>
    </div>
  </div>

  <!-- Browser -->
  <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">
    <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between">
      <h3 class="text-xs font-black text-blue-900 uppercase tracking-[0.2em] italic">Browser</h3>
      <i class="fa fa-compass text-slate-200"></i>
    </div>
    <div class="p-8 flex-1 flex items-center justify-center min-h-[350px]">
      <div id="apexBrowser" class="w-full"></div>
    </div>
  </div>
</div>

<!-- Daily Activity -->
<div class="bg-blue-900 rounded-[3rem] shadow-2xl border border-blue-950 overflow-hidden mb-12">
  <div class="px-10 py-8 border-b border-white/5 flex items-center justify-between bg-blue-950">
    <div>
      <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white italic">Aktivitas</h3>
      <p class="text-[9px] text-blue-300 font-bold mt-1 uppercase tracking-widest italic">Trend harian</p>
    </div>
    <i class="fa fa-bolt text-yellow-400 animate-pulse"></i>
  </div>
  <div class="p-10">
    <div id="apexDaily" class="w-full h-[300px]"></div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-16">
  <!-- Top Pages -->
  <div class="lg:col-span-7">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-xs font-black text-blue-900 uppercase tracking-[0.2em] italic">Halaman Populer</h3>
        <i class="fa fa-fire text-red-600"></i>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-10 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Halaman</th>
              <th class="px-10 py-4 text-center text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Total</th>
              <th class="px-10 py-4 text-right text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Persen</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50 bg-white">
            <?php
            $total_visits_year = array_sum(array_column($monthly_stats, 'total'));
            foreach ($top_pages as $page):
              $percentage = ($total_visits_year > 0) ? round(($page->visit_count / $total_visits_year) * 100, 1) : 0;
            ?>
              <tr class="hover:bg-slate-50 transition-colors group">
                <td class="px-10 py-5">
                  <p class="text-xs font-black text-slate-700 tracking-tight truncate max-w-[300px]"><?= $page->page_visited ?></p>
                </td>
                <td class="px-10 py-5 text-center">
                  <span class="bg-blue-50 text-blue-900 text-[10px] font-black px-2.5 py-1 rounded-lg border border-blue-100 shadow-sm"><?= $page->visit_count ?></span>
                </td>
                <td class="px-10 py-5 text-right">
                  <div class="flex items-center justify-end gap-3">
                    <span class="text-[10px] font-black text-blue-900/40 italic"><?= $percentage ?>%</span>
                    <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden shadow-inner">
                      <div class="h-full bg-blue-900" style="width: <?= $percentage ?>%"></div>
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

  <!-- Log -->
  <div class="lg:col-span-5">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-900 text-white">
        <h3 class="text-xs font-black uppercase tracking-[0.2em] italic">Log Baru</h3>
        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_10px_#10b981]"></span>
      </div>
      <div class="p-6 space-y-4 overflow-y-auto h-[550px] custom-scrollbar">
        <?php foreach ($recent_visits as $visit): ?>
          <div class="p-5 rounded-3xl bg-slate-50 border border-slate-100 group hover:border-blue-900 transition-all">
            <div class="flex justify-between items-start mb-3">
              <span class="text-[9px] font-black text-blue-900 uppercase tracking-widest"><?= $visit->ip_address ?></span>
              <span class="text-[9px] font-bold text-slate-400 tabular-nums italic"><?= date('H:i:s', strtotime($visit->created_at)) ?></span>
            </div>
            <p class="text-[10px] font-black text-slate-700 leading-relaxed line-clamp-1 italic mb-2"><?= $visit->page_visited ?></p>
            <div class="flex items-center gap-2">
              <span class="text-[8px] font-bold text-slate-300 tracking-widest truncate">UA: <?= $visit->user_agent ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
  const brandBlue = '#0000a0';
  const brandYellow = '#ffcb05';
  const brandRed = '#ed1c24';
  const brandSlate = '#1e293b';

  var optionsMonthly = {
    series: [{
      name: 'Total',
      data: [<?php
              $monthly_data = array_fill(0, 12, 0);
              foreach ($monthly_stats as $stat) {
                $monthly_data[$stat->month - 1] = $stat->total;
              }
              echo implode(',', $monthly_data);
              ?>]
    }, {
      name: 'Unique',
      data: [<?php
              $monthly_unique = array_fill(0, 12, 0);
              foreach ($monthly_stats as $stat) {
                $monthly_unique[$stat->month - 1] = $stat->unique;
              }
              echo implode(',', $monthly_unique);
              ?>]
    }],
    chart: {
      type: 'bar',
      height: 350,
      toolbar: {
        show: false
      }
    },
    colors: [brandBlue, brandYellow],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        borderRadius: 10
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
      labels: {
        style: {
          colors: '#94a3b8',
          fontWeight: 900,
          fontSize: '10px'
        }
      }
    },
    yaxis: {
      labels: {
        style: {
          colors: '#94a3b8',
          fontWeight: 900,
          fontSize: '10px'
        },
        formatter: function(val) {
          return val;
        }
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      theme: 'dark',
      y: {
        formatter: function(val) {
          return val;
        }
      }
    },
    legend: {
      position: 'top',
      horizontalAlign: 'right',
      fontWeight: 900,
      labels: {
        colors: '#64748b'
      }
    }
  };
  new ApexCharts(document.querySelector("#apexMonthly"), optionsMonthly).render();

  var optionsOS = {
    series: [<?php echo implode(',', array_column($os_stats, 'count')); ?>],
    labels: [<?php echo implode(',', array_map(function ($v) {
                return "'" . strtoupper($v->os) . "'";
              }, $os_stats)); ?>],
    chart: {
      type: 'donut',
      height: 350
    },
    colors: [brandBlue, brandYellow, brandRed, brandSlate, '#64748b'],
    stroke: {
      show: false
    },
    legend: {
      position: 'bottom',
      fontWeight: 900,
      labels: {
        colors: '#64748b'
      }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          labels: {
            show: true,
            name: {
              fontWeight: 900
            },
            value: {
              fontWeight: 900,
              color: brandBlue,
              formatter: function(val) {
                return val;
              }
            },
            total: {
              show: true,
              fontWeight: 900,
              label: 'OS',
              formatter: function(w) {
                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
              }
            }
          }
        }
      }
    },
    dataLabels: {
      formatter: function (val, opts) {
        return opts.w.globals.series[opts.seriesIndex];
      }
    },
    tooltip: {
      y: {
        formatter: function(val) {
          return val;
        }
      }
    }
  };
  new ApexCharts(document.querySelector("#apexOS"), optionsOS).render();

  var optionsBrowser = {
    series: [<?php echo implode(',', array_column($browser_stats, 'count')); ?>],
    labels: [<?php echo implode(',', array_map(function ($v) {
                return "'" . strtoupper($v->browser) . "'";
              }, $browser_stats)); ?>],
    chart: {
      type: 'donut',
      height: 350
    },
    colors: [brandBlue, brandYellow, brandRed, brandSlate, '#64748b'],
    stroke: {
      show: false
    },
    legend: {
      position: 'bottom',
      fontWeight: 900,
      labels: {
        colors: '#64748b'
      }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          labels: {
            show: true,
            name: {
              fontWeight: 900
            },
            value: {
              fontWeight: 900,
              color: brandBlue,
              formatter: function(val) {
                return val;
              }
            },
            total: {
              show: true,
              fontWeight: 900,
              label: 'BROWSER',
              formatter: function(w) {
                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
              }
            }
          }
        }
      }
    },
    dataLabels: {
      formatter: function (val, opts) {
        return opts.w.globals.series[opts.seriesIndex];
      }
    },
    tooltip: {
      y: {
        formatter: function(val) {
          return val;
        }
      }
    }
  };
  new ApexCharts(document.querySelector("#apexBrowser"), optionsBrowser).render();

  var optionsDaily = {
    series: [{
      name: 'Traffic',
      data: [<?php
              $daily_data = array();
              foreach (array_reverse($daily_stats) as $stat) {
                $daily_data[] = $stat->total_visits;
              }
              echo implode(',', $daily_data);
              ?>]
    }],
    chart: {
      height: 300,
      type: 'area',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      }
    },
    colors: [brandYellow],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 4
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0,
        stops: [0, 90, 100]
      }
    },
    xaxis: {
      categories: [<?php
                    $daily_labels = array();
                    foreach (array_reverse($daily_stats) as $stat) {
                      $daily_labels[] = "'" . date('d M', strtotime($stat->visit_date)) . "'";
                    }
                    echo implode(',', $daily_labels);
                    ?>],
      labels: {
        style: {
          colors: '#93c5fd',
          fontWeight: 900,
          fontSize: '9px'
        }
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    yaxis: {
      labels: {
        style: {
          colors: '#93c5fd',
          fontWeight: 900,
          fontSize: '9px'
        },
        formatter: function(val) {
          return val;
        }
      }
    },
    grid: {
      borderColor: 'rgba(255,255,255,0.05)',
      strokeDashArray: 4
    },
    tooltip: {
      theme: 'dark',
      y: {
        formatter: function(val) {
          return val;
        }
      }
    }
  };
  new ApexCharts(document.querySelector("#apexDaily"), optionsDaily).render();
</script>

<style>
  .custom-scrollbar::-webkit-scrollbar {
    width: 4px;
  }

  .custom-scrollbar::-webkit-scrollbar-track {
    background: #f8fafc;
  }

  .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
  }

  .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
  }
</style>