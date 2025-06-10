<div class="row justify-content-center">
  <div class="col-md-9 col-lg-7">
    <div class="card">
      <div class="card-header bg-success text-white">
        <h3 class="mb-0">Edit Data Alumni</h3>
      </div>
      <div class="card-body">
        <?php
        // print_r($pekerjaan_list); die();
        // print_r($alumni); die();
        ?>
        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <form method="post" action="<?php echo site_url('alumni/update/' . $alumni->id_alumni); ?>">
          <h4>Data Pribadi</h4>

          <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap (sertakan gelar akademik jika ada)</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $alumni->nama_lengkap; ?>" required>
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
                  <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="Laki-laki"
                    <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin) == 'Laki-laki' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="laki">Laki-laki</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan"
                    <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin) == 'Perempuan' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?php echo $alumni->tempat_lahir; ?>" required>
              </div>
              <div class="col-md-6">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $alumni->tanggal_lahir; ?>" required>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
            <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="2" required><?php echo $alumni->alamat_domisili; ?></textarea>
          </div>

          <div class="mb-3">
            <label for="provinsi" class="form-label">Provinsi</label>
            <select class="form-select" id="provinsi" name="provinsi_id" required>
              <option value="">-- Pilih Provinsi --</option>
              <?php foreach ($provinsi as $prov): ?>
                <option value="<?php echo $prov->id_provinsi; ?>" <?php echo ($prov->id_provinsi == $alumni->provinsi_id) ? 'selected' : ''; ?>>
                  <?php echo $prov->nama_provinsi; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
            <select class="form-select" id="kabupaten" name="kabupaten_id" required>
              <option value="">-- Pilih Kabupaten/Kota --</option>
              <?php foreach ($kabupaten as $kab): ?>
                <option value="<?php echo $kab->id_kabupaten; ?>" <?php echo ($kab->id_kabupaten == $alumni->kabupaten_id) ? 'selected' : ''; ?>>
                  <?php echo $kab->nama_kabupaten; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>


          <div class="mb-3">
            <label for="no_telepon" class="form-label">Nomor Telepon/WhatsApp</label>
            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?php echo $alumni->no_telepon; ?>" required>
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
                  for ($tahun = $tahun_mulai; $tahun <= $tahun_sekarang; $tahun++): ?>
                    <option value="<?= $tahun ?>" <?= $tahun == $alumni->angkatan ? 'selected' : '' ?>><?= $tahun ?></option>
                  <?php endfor;
                  ?>
                </select>

              </div>
              <div class="col-md-6">
                <label for="jurusan" class="form-label">Jurusan (jika ada)</label>
                <select name="jurusan" id="jurusan" class="form-select" required>
                  <option value="">-- Pilih Jurusan --</option>
                  <option value="Fisika" <?php echo ("Fisika" == $alumni->jurusan) ? 'selected' : ''; ?>>Fisika (A1)</option>
                  <option value="Biologi" <?php echo ("Biologi" == $alumni->jurusan) ? 'selected' : ''; ?>>Biologi (A2)</option>
                  <option value="Ilmu Sosial" <?php echo ("Sosial" == $alumni->jurusan) ? 'selected' : ''; ?>>Ilmu Sosial (A3)</option>
                  <option value="Ilmu Budaya" <?php echo ("Budaya" == $alumni->jurusan) ? 'selected' : ''; ?>>Ilmu Budaya (A4)</option>
                  <option disabled>──────────</option>
                  <option value="IPA" <?php echo ("IPA" == $alumni->jurusan) ? 'selected' : ''; ?>>IPA</option>
                  <option value="IPS" <?php echo ("IPS" == $alumni->jurusan) ? 'selected' : ''; ?>>IPS</option>
                  <option value="Bahasa" <?php echo ("Bahasa" == $alumni->jurusan) ? 'selected' : ''; ?>>Bahasa</option>
                  <option disabled>──────────</option>
                  <option value="Umum" <?php echo ("Umum" == $alumni->jurusan) ? 'selected' : ''; ?>>Umum / Tidak ada jurusan</option>
                </select>
              </div>
            </div>
          </div>

          <hr>

          <h4>Data Pekerjaan</h4>

          <div class="mb-3">
            <label for="pekerjaan" class="form-label">Pekerjaan</label>
            <select class="form-select" id="pekerjaan" name="id_ref_pekerjaan">
              <option value="">-- Pilih Pekerjaan --</option>
              <?php foreach ($pekerjaan_list as $pekerjaan): ?>
                <option value="<?php echo $pekerjaan->id_ref_pekerjaan; ?>" <?php echo ($pekerjaan->id_ref_pekerjaan == $alumni->id_ref_pekerjaan) ? 'selected' : ''; ?>>
                  <?php echo $pekerjaan->nama_pekerjaan; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="nama_perusahaan" class="form-label">Nama Perusahaan/Instansi</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="<?php echo $alumni->nama_perusahaan; ?>">
          </div>

          <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $alumni->jabatan; ?>">
          </div>

          <div class="mb-3">
            <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
            <textarea class="form-control" id="alamat_kantor" name="alamat_kantor" rows="2"><?php echo $alumni->alamat_kantor; ?></textarea>
          </div>

          <hr>

          <!-- Keterangan Tambahan -->
          <h4>Keterangan Tambahan</h4>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="bergabung_komunitas" name="bergabung_komunitas" value="1" <?php echo ($alumni->bergabung_komunitas) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="bergabung_komunitas">
                Bersedia bergabung dalam komunitas alumni
              </label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="partisipasi_kegiatan" name="partisipasi_kegiatan" value="1" <?php echo ($alumni->partisipasi_kegiatan) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="partisipasi_kegiatan">
                Bersedia berpartisipasi dalam kegiatan sekolah
              </label>
            </div>
          </div>

          <div class="mb-3">
            <label for="saran_masukan" class="form-label">Saran dan Masukan untuk SMA 1/277 Kabupaten Sinjai</label>
            <textarea class="form-control" id="saran_masukan" name="saran_masukan" rows="3"><?php echo $alumni->saran_masukan; ?></textarea>
          </div>
          <input type="hidden" name="id_pekerjaan" value="<?= $alumni->nama_perusahaan ?>">
          <button type="submit" class="btn btn-primary">Update Data</button>
        </form>

      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    // Fungsi untuk mengubah input menjadi huruf kapital
    function convertToUpperCase(inputElement) {
      inputElement.value = inputElement.value.toUpperCase();
    }

    // Daftar field yang ingin diubah menjadi huruf kapital
    const uppercaseFields = [
      'nama_lengkap',
      'nama_panggilan',
      'tempat_lahir',
      'alamat_domisili',
      'nama_perusahaan',
      'jabatan',
      'alamat_kantor'
    ];

    // Terapkan event listener untuk setiap field
    document.addEventListener('DOMContentLoaded', function() {
      uppercaseFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
          // Untuk perubahan langsung saat mengetik
          field.addEventListener('input', function() {
            convertToUpperCase(this);
          });

          // Untuk perubahan saat paste
          field.addEventListener('paste', function(e) {
            setTimeout(() => {
              convertToUpperCase(this);
            }, 0);
          });
        }
      });

      // Tambahkan juga CSS untuk visual feedback
      const style = document.createElement('style');
      style.textContent = `
      ${uppercaseFields.map(id => `#${id}`).join(', ')} {
        text-transform: uppercase;
      }
    `;
      document.head.appendChild(style);
    });

    // Tetap pertahankan script yang sudah ada untuk preview foto
    document.getElementById('foto').addEventListener('change', function(e) {
      const file = e.target.files[0];
      const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];

      if (file) {
        if (!allowedTypes.includes(file.type)) {
          alert('Silakan pilih file gambar (JPEG, PNG, GIF, WEBP, atau SVG)');
          e.target.value = '';
          return;
        }

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

    // Validasi ukuran file
    document.querySelector('form').addEventListener('submit', function(e) {
      const fotoInput = document.getElementById('foto');
      if (fotoInput.files.length > 0) {
        const fileSize = fotoInput.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 10) {
          e.preventDefault();
          alert('Ukuran foto terlalu besar. Maksimal 10MB.');
          return false;
        }
      }
      return true;
    });
  </script>