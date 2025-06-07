<h2 class="mb-4"><?php echo $title; ?></h2>

<div class="row g-4 mb-4">
  <div class="col-6 col-lg-3">
    <div class="card shadow">
      <div class="card-header"><i class="fas fa-users text-success me-2 "></i> Jumlah Alumni</div>
      <div class="card-body">
        <p class="d-flex display-6 fw-bold justify-content-end">
          <?php echo $total_alumni; ?>
            
          </p>
<!--         <p class="d-flex justify-content-end mb-0">
        </p>
 -->      </div>
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
  <div class="col-md-6">
    <div class="card shadow mb-3">
      <div class="card-header">Jumlah Alumni per Angkatan</div>
      <div class="card-body">
        <canvas id="chartAngkatan"></canvas>
      </div>
    </div>

    <div class="card shadow">
      <div class="card-header">Jumlah Alumni per Jurusan</div>
      <div class="card-body">
        <canvas id="chartJurusan"></canvas>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow mb-3">
      <div class="card-header">Pendata Tercepat</div>
      <div class="card-body">
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
              <?php $urut=1; foreach ($alumni_tercepat as $row): ?>
                <tr>
                  <td class="text-center"><?=$urut++?></td>
                  <td class="text-left"><?php echo htmlspecialchars($row->nama_lengkap); ?> / <?php echo htmlspecialchars($row->angkatan); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->created_at); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="card shadow mb-3">
      <div class="card-header">Domisili Alumni</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-nowrap align-middle">
            <thead>
              <tr>
                <th class="text-center">Kabupaten / Provinsi</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alumni_per_kabupaten as $row): ?>
                <tr>
                  <td class="text-left"><?php echo htmlspecialchars($row->nama_kabupaten); ?> - <?php echo htmlspecialchars($row->nama_provinsi); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->total_alumni); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-header">Jenis Kelamin Alumni</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-nowrap align-middle">
            <thead>
              <tr class="text-center">
                <th>Angkatan</th>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($gender_perangkatan as $row): ?>
                <tr>
                  <td class="text-center"><?php echo htmlspecialchars($row->angkatan); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->jumlah_laki_laki); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($row->jumlah_perempuan); ?></td>
                  <td class="text-center"><?php echo $row->jumlah_laki_laki + $row->jumlah_perempuan; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card shadow">
      <div class="card-header">Pekerjaan Alumni</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-nowrap align-middle">
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
</div>

<!-- <p>Total Alumni: <?php echo $total_alumni; ?></p>
<p>Total alumni_per_angkatan: <?php echo json_encode($alumni_per_angkatan); ?></p>
<p>Total alumni_per_jurusan: <?php echo json_encode($alumni_per_jurusan); ?></p> -->
<?php
// print_r($this->input->post());
// die();
?>
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
  console.log(dataJurusan);
  const total = dataJurusan.map(Number).reduce((sum, val) => sum + val, 0);
  console.log(total);

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

  // Pie chart for Jurusan
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
      plugins: {
        legend: {
          position: 'bottom',
        },
        datalabels: {
          color: '#fff',
          font: {
            weight: 'bold',
            size: '16'
          },
          formatter: (value) => {
            const percentage = (value / total * 100).toFixed(1); // 1 angka di belakang koma
            return percentage + '%';
          }
        }
      }
    },
    plugins: [ChartDataLabels] // Aktifkan plugin
  });
</script>


<?php if(isset($menit_reload) && is_numeric($menit_reload) && $menit_reload > 0): ?>
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
            
            if(timeLeft <= 0) {
                clearInterval(countdownInterval);
                window.location.reload();
            }
        }, 1000);

        // Reload halaman setelah X menit
        setTimeout(function(){
            window.location.reload();
        }, <?php echo $menit_reload * 60 * 1000; ?>);
    </script>
<?php endif; ?>