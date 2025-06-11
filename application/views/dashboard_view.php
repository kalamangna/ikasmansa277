<h2 class="mb-4"><?php echo $title; ?></h2>

<div class="row g-4 mb-4">
  <div class="col-6 col-lg-3">
    <div class="card shadow">
      <div class="card-header"><i class="fas fa-users text-success me-2 "></i> Jumlah Alumni</div>
      <div class="card-body">
        <p class="d-flex display-6 fw-bold justify-content-end">
          <?php echo $total_alumni; ?>
        </p>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="card shadow">
      <div class="card-header"><i class="fa fa-graduation-cap text-warning"></i> Jumlah Angkatan</div>
      <div class="card-body">
        <p class="d-flex display-6 fw-bold justify-content-end">
          <?php echo $total_angkatan; ?></p>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card shadow">
      <div class="card-header"><i class="fas fa-male text-primary me-1"></i> Jumlah Laki-laki</div>
      <div class="card-body">
        <p class="d-flex display-6 fw-bold justify-content-end">
          <?php echo $gender_total->total_laki_laki; ?>
        </p>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card shadow">
      <div class="card-header"><i class="fas fa-female text-danger ms-1 me-1"></i> Jumlah Perempuan</div>
      <div class="card-body">
        <p class="d-flex display-6 fw-bold justify-content-end">
          <?php echo $gender_total->total_perempuan; ?>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-4">
    <div class="card shadow h-100">
      <div class="card-header">Jumlah Alumni per Jurusan</div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="chartJurusan"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card shadow h-100">
      <div class="card-header">Jumlah Alumni per Angkatan</div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="chartAngkatan"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-header">Domisili Alumni</div>
      <div class="card-body overflow-auto" style="height: 500px;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">Kabupaten / Provinsi</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alumni_per_kabupaten as $row): ?>
                <tr>
                  <td class="text-left align-middle"><?php echo htmlspecialchars($row->nama_kabupaten); ?> - <?php echo htmlspecialchars($row->nama_provinsi); ?></td>
                  <td class="text-center align-middle"><?php echo htmlspecialchars($row->total_alumni); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="card shadow mb-4">
      <div class="card-header">Rekap per Angkatan</div>
      <div class="card-body overflow-auto" style="height: 500px;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-nowrap align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Angkatan</th>
                <th class="text-center">Laki-laki</th>
                <th class="text-center">Perempuan</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php $u1 = 1;
              foreach ($gender_perangkatan as $row): ?>
                <tr>
                  <td class="text-center"><?php echo $u1++; ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->angkatan); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->jumlah_laki_laki); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->jumlah_perempuan); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->total_semua); ?></td>
                  <!-- <td class="text-center"><?php echo $row->jumlah_laki_laki + $row->jumlah_perempuan; ?></td> -->
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="card shadow mb-4">
      <div class="card-header">Pekerjaan Alumni</div>
      <div class="card-body overflow-auto" style="height: 500px;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">Pekerjaan</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alumni_per_pekerjaan as $row): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row->nama_pekerjaan); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->total_alumni); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </div>

  <div class="col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-header">Data Terbaru</div>
      <div class="card-body overflow-auto" style="height: 500px;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-nowrap align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Nama / Angkatan</th>
                <th class="text-center">Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php $urut = 1;
              foreach ($alumni_terbaru as $row): ?>
                <tr>
                  <td class="text-center"><?= $urut++ ?></td>
                  <td class="text-left"><?php echo htmlspecialchars($row->nama_lengkap); ?> / <?php echo htmlspecialchars($row->angkatan); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->created_at); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header">Data Tercepat</div>
      <div class="card-body overflow-auto" style="height: 500px;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-nowrap align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Nama / Angkatan</th>
                <th class="text-center">Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php $urut = 1;
              foreach ($alumni_tercepat as $row): ?>
                <tr>
                  <td class="text-center"><?= $urut++ ?></td>
                  <td class="text-left"><?php echo htmlspecialchars($row->nama_lengkap); ?> / <?php echo htmlspecialchars($row->angkatan); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->created_at); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header">Referral Terbanyak</div>
      <div class="card-body overflow-auto" style="height: 500px;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center align-middle">No.</th>
                <th class="text-center align-middle">Nama / Angkatan</th>
                <th class="text-center align-middle">Jumlah Ref</th>
              </tr>
            </thead>
            <tbody>
              <?php $urut = 1;
              foreach ($get_referred_rank as $row): ?>
                <tr>
                  <td class="text-center align-middle"><?= $urut++ ?></td>
                  <td class="text-left align-middle"><?php echo htmlspecialchars($row->nama_lengkap); ?> / <?php echo htmlspecialchars($row->angkatan); ?></td>
                  <td class="text-center align-middle"><?php echo htmlspecialchars($row->ref_jumlah); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
</div>

<style>
  /* CSS untuk chart selalu sama tinggi */
  .chart-container {
    position: relative;
    height: 200px;
  }

  @media (min-width: 768px) {
    .chart-container {
      height: 300px;
    }
  }

  canvas {
    width: 100% !important;
    height: 100% !important;
  }
</style>


<script>
  // Mengambil data dari PHP ke JavaScript
  var ctxAngkatan = document.getElementById('chartAngkatan').getContext('2d');
  var ctxJurusan = document.getElementById('chartJurusan').getContext('2d');

  // Data untuk chart
  var labelAngkatan = <?php echo json_encode(array_column($alumni_per_angkatan, 'angkatan')); ?>;
  var labelJurusan = <?php echo json_encode(array_column($alumni_per_jurusan, 'jurusan')); ?>;
  var dataAngkatan = <?php echo json_encode(array_column($alumni_per_angkatan, 'jumlah_alumni')); ?>;
  var dataJurusan = <?php echo json_encode(array_column($alumni_per_jurusan, 'jumlah_alumni')); ?>;

  // Menghitung total alumni per jurusan
  const total = dataJurusan.map(Number).reduce((sum, val) => sum + val, 0);


  // Bar chart for Angkatan
  var chartAngkatan = new Chart(ctxAngkatan, {
    type: 'bar',
    data: {
      labels: labelAngkatan,
      datasets: [{
        label: 'Jumlah Alumni',
        data: dataAngkatan,
        backgroundColor: [
          '#0d6efd',
          '#dc3545',
          '#198754',
          '#fd7e14',
          '#6f42c1',
          '#20c997',
          '#ffc107',
          '#6610f2'
        ],
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          precision: 0,
          ticks: {
            // Menghilangkan koma (angka desimal)
            callback: function(value) {
              return Number.isInteger(value) ? value : '';
            },
            stepSize: 1
          }
        }
      },
      plugins: {
        legend: {
          display: false // ⛔ Legend disembunyikan
        }
      },
    }
  });

  // Bar chart for Jurusan
  var chartJurusan = new Chart(ctxJurusan, {
    type: 'pie',
    data: {
      labels: labelJurusan,
      datasets: [{
        label: 'Jumlah Alumni',
        data: dataJurusan,
        backgroundColor: [
          '#0d6efd',
          '#dc3545',
          '#198754',
          '#fd7e14',
          '#6f42c1',
          '#20c997',
          '#ffc107',
          '#6610f2'
        ],
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom', // Posisi legend di atas,
        },
      }
    },
  });
</script>


<!-- Reload otomatis -->
<?php if (isset($menit_reload) && is_numeric($menit_reload) && $menit_reload > 0): ?>
  <div class="reload-info" style="position: fixed; bottom: 10px; right: 10px; background: #f8f9fa; padding: 10px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); z-index: 1000;">
    <p>Halaman akan reload otomatis setiap <?php echo $menit_reload; ?> menit (<span id="countdown"><?php echo $menit_reload * 60; ?></span> detik)</p>
  </div>

  <script>
    // Hitung mundur
    let timeLeft = <?php echo $menit_reload * 60; ?>;
    const countdownElement = document.getElementById('countdown');

    const countdownInterval = setInterval(() => {
      timeLeft--;
      countdownElement.textContent = timeLeft;

      if (timeLeft <= 0) {
        clearInterval(countdownInterval);
        window.location.reload();
      }
    }, 1000);

    // Reload halaman setelah X menit
    setTimeout(function() {
      window.location.reload();
    }, <?php echo $menit_reload * 60 * 1000; ?>);
  </script>
<?php endif; ?>