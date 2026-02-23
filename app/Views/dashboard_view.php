<?php
$session = session();
$is_admin = $session->get('role') == 'admin' ? 1 : null;
?>

<div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-y-6">
  <div>
    <h1 class="text-3xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">Dashboard</h1>
    <p class="text-sm text-slate-400 font-bold mt-2 uppercase tracking-widest leading-none">Statistik & Analitik</p>
  </div>
  <div class="flex items-center gap-x-4">
    <div class="flex items-center gap-x-2 px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-200 ring-4 ring-slate-100">
      <span class="relative flex h-2 w-2">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
      </span>
      <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Aktif</span>
    </div>
  </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
  <div class="bg-blue-900 p-6 rounded-[2rem] shadow-xl shadow-blue-900/30 flex flex-col relative overflow-hidden group border-b-8 border-blue-950">
    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-500"><i class="fas fa-users text-[10rem] text-white italic"></i></div>
    <div class="flex items-center gap-x-3 mb-8 relative z-10">
      <div class="p-2.5 bg-white/10 rounded-2xl backdrop-blur-xl ring-1 ring-white/20"><i class="fas fa-users text-yellow-400 text-lg"></i></div>
      <span class="text-[10px] font-black text-blue-100 uppercase tracking-[0.2em]">Alumni</span>
    </div>
    <div class="mt-auto relative z-10">
      <p class="text-5xl font-black text-white tracking-tighter tabular-nums leading-none"><?= ($gender_total->total_laki_laki ?? 0) + ($gender_total->total_perempuan ?? 0); ?></p>
      <p class="text-[10px] font-black text-blue-300 uppercase tracking-[0.3em] mt-3 flex items-center gap-2"><span class="h-1 w-4 bg-yellow-400 rounded-full"></span> Total Terdata</p>
    </div>
  </div>

  <div class="bg-yellow-400 p-6 rounded-[2rem] shadow-xl shadow-yellow-400/20 flex flex-col relative overflow-hidden group border-b-8 border-yellow-500">
    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-500"><i class="fa fa-graduation-cap text-[10rem] text-blue-900 italic"></i></div>
    <div class="flex items-center gap-x-3 mb-8 relative z-10">
      <div class="p-2.5 bg-blue-900/5 rounded-2xl backdrop-blur-xl ring-1 ring-blue-900/10"><i class="fa fa-graduation-cap text-blue-900 text-lg"></i></div>
      <span class="text-[10px] font-black text-blue-900/60 uppercase tracking-[0.2em]">Angkatan</span>
    </div>
    <div class="mt-auto relative z-10">
      <p class="text-5xl font-black text-blue-900 tracking-tighter tabular-nums leading-none"><?= $total_angkatan ?? 0; ?></p>
      <p class="text-[10px] font-black text-blue-300 uppercase tracking-[0.3em] mt-3 flex items-center gap-2"><span class="h-1 w-4 bg-blue-900/20 rounded-full"></span> Total Angkatan</p>
    </div>
  </div>

  <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-slate-100 flex flex-col group hover:border-blue-800 transition-all border-b-8 border-slate-200">
    <div class="flex items-center gap-x-3 mb-8">
      <div class="p-2.5 bg-blue-50 rounded-2xl group-hover:bg-blue-900 transition-all group-hover:shadow-lg group-hover:shadow-blue-200"><i class="fas fa-male text-blue-800 text-lg group-hover:text-yellow-400 transition-colors"></i></div>
      <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Laki-laki</span>
    </div>
    <div class="mt-auto">
      <p class="text-5xl font-black text-slate-800 tracking-tighter tabular-nums group-hover:text-blue-900 transition-colors leading-none"><?= $gender_total->total_laki_laki ?? 0; ?></p>
      <div class="flex items-center gap-x-3 mt-4">
        <?php 
          $total = ($gender_total->total_laki_laki ?? 0) + ($gender_total->total_perempuan ?? 0);
          $pct = ($total > 0) ? round(($gender_total->total_laki_laki / $total) * 100) : 0;
        ?>
        <span class="text-[10px] font-black text-blue-800 italic"><?= $pct ?>%</span>
      </div>
    </div>
  </div>

  <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-slate-100 flex flex-col group hover:border-red-600 transition-all border-b-8 border-slate-200">
    <div class="flex items-center gap-x-3 mb-8">
      <div class="p-2.5 bg-red-50 rounded-2xl group-hover:bg-red-600 transition-all group-hover:shadow-lg group-hover:shadow-red-200"><i class="fas fa-female text-red-600 text-lg group-hover:text-white transition-colors"></i></div>
      <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Perempuan</span>
    </div>
    <div class="mt-auto">
      <p class="text-5xl font-black text-slate-800 tracking-tighter tabular-nums group-hover:text-red-600 transition-colors leading-none"><?= $gender_total->total_perempuan ?? 0; ?></p>
      <div class="flex items-center gap-x-3 mt-4">
        <?php 
          $pct_p = ($total > 0) ? round(($gender_total->total_perempuan / $total) * 100) : 0;
        ?>
        <span class="text-[10px] font-black text-red-600 italic"><?= $pct_p ?>%</span>
      </div>
    </div>
  </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
  <div class="lg:col-span-12">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden h-full flex flex-col">
      <div class="px-10 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Trend Angkatan</h3>
        <div class="h-8 w-8 rounded-xl bg-white shadow-sm flex items-center justify-center border border-slate-100"><i class="fa fa-chart-line text-blue-900 text-xs"></i></div>
      </div>
      <div class="p-8 flex-1 min-h-[350px]">
        <div id="apexAngkatan" class="w-full h-full"></div>
      </div>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
  <div class="lg:col-span-6">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden h-full flex flex-col">
      <div class="px-10 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Distribusi Jurusan</h3>
        <div class="h-8 w-8 rounded-xl bg-white shadow-sm flex items-center justify-center border border-slate-100"><i class="fa fa-chart-pie text-blue-900 text-xs"></i></div>
      </div>
      <div class="p-8 flex-1 flex flex-col items-center justify-center min-h-[350px]">
        <div id="apexJurusan" class="w-full"></div>
      </div>
    </div>
  </div>

  <div class="lg:col-span-6">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden h-full flex flex-col">
      <div class="px-10 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Distribusi Jenis Kelamin</h3>
        <div class="h-8 w-8 rounded-xl bg-white shadow-sm flex items-center justify-center border border-slate-100"><i class="fa fa-venus-mars text-blue-900 text-xs"></i></div>
      </div>
      <div class="p-8 flex-1 flex flex-col items-center justify-center min-h-[350px]">
        <div id="apexGender" class="w-full"></div>
      </div>
    </div>
  </div>
</div>

<!-- Data Tables -->
<div class="space-y-10 mb-16">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Domisili -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-blue-900 italic">Domisili</h3>
        <span class="bg-blue-50 text-blue-900 text-[9px] font-black px-3 py-1 rounded-full border border-blue-100 uppercase tracking-widest"><?= count($alumni_per_kabupaten) ?> Wilayah</span>
      </div>
      <div class="overflow-y-auto h-[400px] custom-scrollbar">
        <table class="min-w-full divide-y divide-slate-50">
          <thead class="bg-slate-50 sticky top-0 z-10">
            <tr>
              <th class="px-10 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Wilayah</th>
              <th class="px-10 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50 bg-white">
            <?php foreach ($alumni_per_kabupaten as $row): ?>
              <tr class="hover:bg-slate-50 transition-colors group">
                <td class="px-10 py-5">
                  <div class="flex items-center gap-x-3">
                    <div class="h-2 w-2 rounded-full bg-blue-900 opacity-20 group-hover:opacity-100 transition-opacity"></div>
                    <p class="text-sm font-bold text-slate-700 uppercase tracking-tight"><?= esc($row->nama_kabupaten) ?> - <?= esc($row->nama_provinsi) ?></p>
                  </div>
                </td>
                <td class="px-10 py-5 text-center">
                  <span class="bg-blue-900 text-yellow-400 text-[10px] font-black px-3 py-1.5 rounded-xl shadow-lg"><?= $row->total_alumni ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pekerjaan -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-blue-900 italic">Pekerjaan</h3>
        <i class="fa fa-briefcase text-slate-200"></i>
      </div>
      <div class="overflow-y-auto h-[400px] custom-scrollbar">
        <div class="p-6 grid grid-cols-1 gap-3">
          <?php foreach ($alumni_per_pekerjaan as $row): ?>
            <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-yellow-400 hover:bg-white transition-all group">
              <div class="flex items-center gap-x-4">
                <div class="h-10 w-10 rounded-xl bg-white flex items-center justify-center text-slate-400 group-hover:text-blue-900 shadow-sm italic font-black text-xs"><?= esc(substr($row->nama_pekerjaan, 0, 1)) ?></div>
                <p class="text-xs font-black text-slate-700 uppercase tracking-tight"><?= esc($row->nama_pekerjaan) ?></p>
              </div>
              <p class="text-sm font-black text-blue-900 tabular-nums"><?= $row->total_alumni ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Rekap Angkatan -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
      <div class="px-10 py-6 border-b border-slate-100 bg-blue-900 text-white flex items-center justify-between">
        <h3 class="text-sm font-black uppercase tracking-[0.2em] leading-none italic">Rekap Angkatan</h3>
        <i class="fa fa-layer-group text-yellow-400"></i>
      </div>
      <div class="overflow-y-auto h-[450px] custom-scrollbar">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50 sticky top-0 z-10 shadow-sm">
            <tr>
              <th class="px-10 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Angkatan</th>
              <th class="px-10 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">L</th>
              <th class="px-10 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">P</th>
              <th class="px-10 py-4 text-center text-[10px] font-black text-blue-900 uppercase tracking-widest underline">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50 bg-white">
            <?php foreach ($gender_perangkatan as $row): ?>
              <tr class="hover:bg-blue-50/30 transition-colors">
                <td class="px-10 py-5 text-sm font-black text-slate-700 tabular-nums uppercase">Angkatan <?= esc($row->angkatan) ?></td>
                <td class="px-10 py-5 text-xs font-bold text-slate-500 text-center"><?= $row->jumlah_laki_laki ?></td>
                <td class="px-10 py-5 text-xs font-bold text-slate-500 text-center"><?= $row->jumlah_perempuan ?></td>
                <td class="px-10 py-5 text-sm font-black text-blue-900 text-center italic"><?= $row->jumlah_laki_laki + $row->jumlah_perempuan ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Log Baru -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between bg-red-600 text-white">
        <h3 class="text-sm font-black uppercase tracking-[0.2em] leading-none italic">Log Baru</h3>
        <i class="fa fa-bolt-lightning text-yellow-400 animate-pulse"></i>
      </div>
      <div class="overflow-y-auto h-[450px] p-6 space-y-4 custom-scrollbar">
        <?php foreach ($alumni_terbaru as $row): ?>
          <div class="flex items-center gap-x-5 p-5 rounded-3xl bg-slate-50 border border-slate-100 group hover:border-red-600 transition-all">
            <div class="h-12 w-12 rounded-2xl bg-white border border-slate-100 flex-shrink-0 flex items-center justify-center text-slate-300 group-hover:bg-red-600 group-hover:text-white transition-all shadow-inner"><i class="fa fa-user-check text-lg"></i></div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-black text-slate-800 group-hover:text-red-600 uppercase truncate leading-none mb-1.5"><?= esc($row->nama_lengkap) ?></p>
              <div class="flex items-center gap-x-2">
                <span class="inline-flex items-center rounded-md bg-blue-100 px-2 py-0.5 text-[9px] font-black text-blue-900 uppercase">Angkatan <?= esc($row->angkatan) ?></span>
                <span class="text-[9px] font-bold text-slate-400 tabular-nums italic"><?= date('d/m/Y H:i', strtotime($row->created_at)) ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Referral -->
    <div class="bg-blue-950 rounded-[2rem] shadow-2xl p-1">
      <div class="bg-blue-900 rounded-[1.9rem] overflow-hidden">
        <div class="px-10 py-6 border-b border-white/5 flex items-center justify-between">
          <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white italic">Referral</h3>
          <i class="fa fa-trophy text-yellow-400 text-xl"></i>
        </div>
        <div class="p-6 space-y-3">
          <?php foreach ($get_referred_rank as $row): ?>
            <div class="flex items-center gap-x-5 p-5 rounded-[1.5rem] bg-white/5 hover:bg-white/10 transition-all group">
              <div class="h-12 w-12 rounded-2xl bg-blue-800 flex items-center justify-center text-yellow-400 font-black italic shadow-inner group-hover:scale-110 transition-transform">#</div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-black uppercase truncate mb-1 text-white leading-none"><?= esc($row->nama_lengkap) ?></p>
                <p class="text-[9px] font-bold text-blue-300 uppercase tracking-widest italic">Angkatan <?= esc($row->angkatan) ?></p>
              </div>
              <div class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-2xl text-xs font-black ring-8 ring-blue-900 shadow-xl">
                <?= $row->ref_jumlah ?> <span class="text-[8px] opacity-60">REF</span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Admin -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-900 text-white">
        <h3 class="text-sm font-black uppercase tracking-[0.2em] italic">Admin</h3>
        <i class="fa fa-shield-halved text-blue-400"></i>
      </div>
      <div class="p-6 space-y-4 custom-scrollbar overflow-y-auto">
        <?php foreach ($get_admin_alumni as $row): ?>
          <div class="flex items-center gap-x-5 p-5 rounded-[1.5rem] border border-slate-100 hover:border-blue-900 transition-all bg-slate-50/50 hover:bg-white group">
            <div class="h-12 w-12 rounded-2xl bg-slate-200 flex items-center justify-center text-slate-500 font-black italic group-hover:bg-blue-900 group-hover:text-yellow-400 transition-all uppercase leading-none"><?= esc(substr($row['nama_lengkap'], 0, 1)) ?></div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-black text-slate-800 uppercase leading-none mb-1.5 transition-colors italic"><?= esc($row['nama_lengkap']) ?></p>
              <div class="flex items-center gap-x-2">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic leading-none">Angkatan <?= esc($row['angkatan']) ?></span>
                <span class="text-[9px] font-black text-blue-800 uppercase tracking-[0.1em] italic leading-none"><?= esc(str_replace('_', ' ', $row['nama_role'])) ?></span>
              </div>
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

  var optionsJurusan = {
    series: <?= json_encode(array_values(array_map('intval', array_column($alumni_per_jurusan, 'jumlah_alumni')))); ?>,
    labels: <?= json_encode(array_column($alumni_per_jurusan, 'jurusan')); ?>,
    chart: {
      type: 'donut',
      height: 350
    },
    colors: [brandBlue, brandYellow, brandRed, brandSlate, '#64748b', '#94a3b8'],
    stroke: {
      show: false
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      position: 'bottom',
      fontWeight: 900,
      fontSize: '10px',
      markers: {
        radius: 4
      },
      itemMargin: {
        vertical: 10
      }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          labels: {
            show: true,
            name: {
              fontSize: '10px',
              fontWeight: 900,
              color: '#94a3b8'
            },
            value: {
              fontSize: '24px',
              fontWeight: 900,
              color: brandBlue
            },
            total: {
              show: true,
              label: 'ALUMNI',
              fontWeight: 900,
              color: '#94a3b8'
            }
          }
        }
      }
    }
  };
  new ApexCharts(document.querySelector("#apexJurusan"), optionsJurusan).render();

  var optionsGender = {
    series: [<?= (int)($gender_total->total_laki_laki ?? 0); ?>, <?= (int)($gender_total->total_perempuan ?? 0); ?>],
    labels: ['Laki-laki', 'Perempuan'],
    chart: {
      type: 'donut',
      height: 350
    },
    colors: [brandBlue, brandRed],
    stroke: {
      show: false
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      position: 'bottom',
      fontWeight: 900,
      fontSize: '10px',
      markers: {
        radius: 4
      },
      itemMargin: {
        vertical: 10
      }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          labels: {
            show: true,
            name: {
              fontSize: '10px',
              fontWeight: 900,
              color: '#94a3b8'
            },
            value: {
              fontSize: '24px',
              fontWeight: 900,
              color: brandBlue
            },
            total: {
              show: true,
              label: 'ALUMNI',
              fontWeight: 900,
              color: '#94a3b8'
            }
          }
        }
      }
    }
  };
  new ApexCharts(document.querySelector("#apexGender"), optionsGender).render();

  var optionsAngkatan = {
    series: [{
      name: 'Jumlah Alumni',
      data: <?= json_encode(array_values(array_map('intval', array_column($alumni_per_angkatan, 'jumlah_alumni')))); ?>
    }],
    chart: {
      type: 'bar',
      height: 500,
      toolbar: {
        show: true,
        tools: {
          download: false,
          selection: true,
          zoom: true,
          zoomin: true,
          zoomout: true,
          pan: true,
          reset: true
        }
      },
      zoom: {
        enabled: true,
        type: 'x',
        autoScaleYaxis: true
      },
      animations: {
        enabled: true,
        easing: 'easeinout',
        speed: 800
      },
      parentHeightOffset: 0
    },
    plotOptions: {
      bar: {
        columnWidth: '50%',
        borderRadius: 4,
        distributed: true
      }
    },
    colors: [brandBlue, brandYellow, brandRed, brandSlate, '#64748b', '#94a3b8', '#a3b864', '#b86474'],
    xaxis: {
      categories: <?= json_encode(array_column($alumni_per_angkatan, 'angkatan')); ?>,
      labels: {
        rotate: -45,
        rotateAlways: true,
        hideOverlappingLabels: true,
        showDuplicates: false,
        style: {
          colors: '#94a3b8',
          fontSize: '10px',
          fontWeight: 900
        }
      },
      tickAmount: 10,
      title: {
        text: 'Angkatan'
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    yaxis: {
      title: {
        text: 'Jumlah Alumni'
      },
      labels: {
        style: {
          colors: '#94a3b8',
          fontSize: '10px',
          fontWeight: 900
        }
      }
    },
    legend: {
      show: false
    },
    grid: {
      borderColor: '#e7e7e7',
      strokeDashArray: 4,
      row: {
        colors: ['#f3f3f3', 'transparent'],
        opacity: 0.5
      }
    },
    dataLabels: {
      enabled: false
    },
    tooltip: {
      enabled: true,
      shared: true,
      intersect: false,
      theme: 'dark',
      y: {
        formatter: function(val) {
          return val + " Alumni";
        }
      }
    },
    responsive: [{
      breakpoint: 800,
      options: {
        xaxis: {
          labels: {
            rotate: -90
          }
        }
      }
    }]
  };
  new ApexCharts(document.querySelector("#apexAngkatan"), optionsAngkatan).render();
</script>

<?php if (isset($menit_reload) && is_numeric($menit_reload) && $menit_reload > 0): ?>
  <div class="fixed bottom-10 right-10 z-50">
    <div class="bg-blue-950 text-white px-6 py-4 rounded-[1.5rem] shadow-2xl border-b-4 border-yellow-400 flex items-center gap-x-5 ring-8 ring-blue-900/10 backdrop-blur-lg">
      <div class="h-10 w-10 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10">
        <i class="fa fa-rotate text-yellow-400 animate-spin text-lg"></i>
      </div>
      <div>
        <p class="text-[9px] font-black text-blue-300 uppercase tracking-[0.2em] leading-none mb-1.5 italic">Sync...</p>
        <p class="text-sm font-black tabular-nums tracking-tighter leading-none text-white"><span id="countdown"><?php echo (int)$menit_reload * 60; ?></span>S</p>
      </div>
    </div>
  </div>
  <script>
    let timeLeft = <?= (int)$menit_reload * 60; ?>;
    const countdownEl = document.getElementById('countdown');
    setInterval(() => {
      timeLeft--;
      if (countdownEl) countdownEl.textContent = timeLeft;
      if (timeLeft <= 0) window.location.reload();
    }, 1000);
  </script>
<?php endif; ?>

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
