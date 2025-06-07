    <style>
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; }
        #countdown {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #f44336;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <div id="countdown">Sisa Waktu: <span id="time">02:00</span></div>
    
    <!-- <h1>Form Pendataan</h1> -->
<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="row justify-content-center">
  <div class="col-md-9 col-lg-7">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Form Pendataan Alumni</h3>
      </div>
      <div class="card-body">
        <div class="alert alert-warning" role="alert">
          <strong>Perhatian!</strong><br>
          Data Pribadi dijamin tidak untuk dipublish.<br>
          Jika alumni berminat mengetahui informasi / keberadaan teman alumni, dapat dilakukan dengan menghubungi admin dan selanjutnya admin dapat memberikan data setelah mendapat persetujuan pemilik data pribadi.
        </div>

        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <form method="post" action="<?php echo site_url('alumni/save?ut=' . $this->input->get('ut')); ?>" enctype="multipart/form-data">
          <h4>Data Pribadi</h4>

          <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
          </div>

          <div class="mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="<?php echo set_value('nama_panggilan', $alumni->nama_panggilan ?? ''); ?>">
              </div>
              <div class="col-md-6">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="laki" name="jenis_kelamin" value="Laki-laki" <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin ?? '') == 'Laki-laki' ? 'checked' : ''; ?> required>
                  <label class="form-check-label" for="laki">Laki-laki</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin ?? '') == 'Perempuan' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
              </div>
              <div class="col-md-6">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
              </div>
            </div>
          </div>
          <!--           <div class="mb-3">
              <label for="foto" class="form-label">Foto Alumni (harus potrait)</label>
              <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
          </div>
 -->
          <div class="mb-3">
            <label for="provinsi" class="form-label">Provinsi</label>
            <select class="form-select" id="provinsi" name="provinsi_id" required>
              <option value="">-- Pilih Provinsi --</option>
              <?php foreach ($provinsi as $prov): ?>
                <option value="<?php echo $prov->id_provinsi; ?>"><?php echo $prov->nama_provinsi; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
            <select class="form-select" id="kabupaten" name="kabupaten_id" required>
              <option value="">-- Pilih Kabupaten/Kota --</option>
              <!-- Bisa diisi via AJAX berdasarkan provinsi -->
            </select>
          </div>

          <div class="mb-3">
            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
            <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="2" required></textarea>
          </div>

          <div class="mb-3">
            <label for="no_telepon" class="form-label">Nomor Telepon/WhatsApp</label>
            <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
          </div>

          <!-- Input Email dan Password untuk user login -->
          <div class="mb-3">
            <label for="email" class="form-label">Email (untuk login)</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password (untuk login)</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <hr>

          <h4>Data Angkatan</h4>

          <div class="mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="angkatan" class="form-label">Angkatan (Tahun Lulus)</label>
                <select name="angkatan" id="angkatan" class="form-select" required>
                  <option value="">-- Pilih Angkatan --</option>
                  <?php
                  $tahun_mulai = 1966;
                  $tahun_sekarang = date('Y');
                  for ($tahun = $tahun_mulai; $tahun <= $tahun_sekarang; $tahun++) {
                    // Jika ingin tahun terbaru di atas, gunakan: for ($tahun = $tahun_sekarang; $tahun >= $tahun_mulai; $tahun--)
                    echo '<option value="' . $tahun . '">' . $tahun . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="jurusan" class="form-label">Jurusan</label>
                <select name="jurusan" id="jurusan" class="form-select" required>
                  <option value="">-- Pilih Jurusan --</option>
                  <!-- Jurusan SMA -->
                  <option value="Fisika">Fisika (A1)</option>
                  <option value="Biologi">Biologi (A2)</option>
                  <option value="Ilmu Sosial">Ilmu Sosial (A3)</option>
                  <option value="Ilmu Budaya">Ilmu Budaya (A4)</option>
                  <option disabled>──────────</option>
                  <option value="IPA">IPA</option>
                  <option value="IPS">IPS</option>
                  <option value="Bahasa">Bahasa</option>
                  <option disabled>──────────</option>
                  <option value="Umum">Umum / Tidak ada jurusan</option>
                </select>
              </div>
            </div>
          </div>


          <hr>
          <!-- Data Pekerjaan -->
          <h4>Data Pekerjaan</h4>
          <div class="mb-3">
            <label for="pekerjaan" class="form-label">Pekerjaan</label>
            <select class="form-select" id="pekerjaan" name="id_ref_pekerjaan">
              <option value="">-- Pilih Pekerjaan --</option>
              <?php
              $current_group = '';
              foreach ($pekerjaan_list as $p) {
                if ($p->grup_pekerjaan != $current_group) {
                  if ($current_group != '') {
                    echo '</optgroup>';
                  }
                  $current_group = $p->grup_pekerjaan;
                  echo '<optgroup label="' . htmlspecialchars($current_group) . '">';
                }
                echo '<option value="' . $p->id_ref_pekerjaan . '">' . htmlspecialchars($p->nama_pekerjaan) . '</option>';
              }
              if ($current_group != '') {
                echo '</optgroup>';
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="nama_perusahaan" class="form-label">Nama Perusahaan/Instansi</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan">
          </div>

          <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan">
          </div>

          <div class="mb-3">
            <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
            <textarea class="form-control" id="alamat_kantor" name="alamat_kantor" rows="2"></textarea>
          </div>

          <hr>
          <!-- Foto -->
        <div class="mb-3">
          <label for="foto" class="form-label">Foto Profil</label>
          <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
          <small class="text-muted">Format: JPG/PNG, maksimal 2MB (disarankan foto portrait)</small>
          <div id="preview-container" class="mt-2" style="display:none;">
            <img id="preview-image" src="#" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
          </div>
        </div>

        <!-- Add this script at the bottom of the page, before the closing </body> tag -->


          <!-- Keterangan Tambahan -->
          <h4>Keterangan Tambahan</h4>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="bergabung_komunitas" name="bergabung_komunitas" value="1">
              <label class="form-check-label" for="bergabung_komunitas">
                Bersedia bergabung dalam komunitas alumni
              </label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="partisipasi_kegiatan" name="partisipasi_kegiatan" value="1">
              <label class="form-check-label" for="partisipasi_kegiatan">
                Bersedia berpartisipasi dalam kegiatan sekolah
              </label>
            </div>
          </div>

          <div class="mb-3">
            <label for="saran_masukan" class="form-label">Saran dan Masukan untuk IKA SMA 1/277 Kabupaten Sinjai</label>
            <textarea class="form-control" id="saran_masukan" name="saran_masukan" rows="3"></textarea>
          </div>

          <!-- input kode refferal -->
          <!-- <input type="hidden" name="referred_by" value="<?php echo $referred_by; ?>"> -->

          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
      </div>
    </div>

  </div>
</div>

    <script>
    $(document).ready(function() {
        // Format waktu dari detik ke MM:SS
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            seconds %= 60;
            return [
                minutes.toString().padStart(2, '0'),
                seconds.toString().padStart(2, '0')
            ].join(':');
        }

        // Fungsi untuk update countdown
        function updateCountdown() {
            $.getJSON("<?= site_url('launch/get_remaining_time') ?>", function(response) {
                if(response.is_active) {
                    $('#time').text(formatTime(response.remaining));
                    
                    // Warna merah ketika waktu < 30 detik
                    if(response.remaining < 30) {
                        $('#countdown').css('background', '#ff0000');
                    }
                    
                    setTimeout(updateCountdown, 1000);
                } else {
                    // Waktu habis
                    $('#time').text('00:00');
                    $('#countdown').css('background', '#ff0000').text('WAKTU HABIS');
                    $('#submitBtn').prop('disabled', true);
                    alert('Waktu pendataan telah habis! Form tidak dapat disubmit.');
                }
            }).fail(function() {
                setTimeout(updateCountdown, 1000);
            });
        }

        // Mulai countdown
        updateCountdown();

        // Handle form submission ketika waktu habis
        $('#dataForm').submit(function(e) {
            $.ajax({
                url: "<?= site_url('launch/get_remaining_time') ?>",
                async: false,
                dataType: 'json',
                success: function(response) {
                    if(!response.is_active) {
                        e.preventDefault();
                        alert('Waktu pendataan telah habis! Data tidak dapat disimpan.');
                    }
                }
            });
        });
    });
    </script>

<script>
  // Photo preview functionality
  document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        
        previewImage.src = event.target.result;
        previewContainer.style.display = 'block';
      }
      reader.readAsDataURL(file);
    }
  });

  // File size validation
  document.querySelector('form').addEventListener('submit', function(e) {
    const fotoInput = document.getElementById('foto');
    if (fotoInput.files.length > 0) {
      const fileSize = fotoInput.files[0].size / 1024 / 1024; // in MB
      if (fileSize > 2) {
        e.preventDefault();
        alert('Ukuran foto terlalu besar. Maksimal 2MB.');
        return false;
      }
    }
    return true;
  });
</script>
<!-- 
</body>
</html> -->