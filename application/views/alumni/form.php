<!--  -->
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

        <form method="post" action="<?php echo site_url('alumni/save?ut=' . $this->input->get('ut')); ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
          <h4>Data Pribadi</h4>

          <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap <small class="text-muted">(Wajib diisi)</small></label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
            <small class="text-muted">Isikan nama lengkap sesuai ijazah</small>
            <div class="invalid-feedback">*Nama lengkap wajib diisi.</div>
          </div>

          <div class="mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nama_panggilan" class="form-label">Nama Panggilan <small class="text-muted">(Opsional)</small></label>
                <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="<?php echo set_value('nama_panggilan', $alumni->nama_panggilan ?? ''); ?>">
                <small class="text-muted">Nama yang biasa dipanggil sehari-hari</small>
              </div>

              <div class="col-md-6">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <small class="text-muted">(Wajib diisi)</small></label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="laki" name="jenis_kelamin" value="Laki-laki" <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin ?? '') == 'Laki-laki' ? 'checked' : ''; ?> required>
                  <label class="form-check-label" for="laki">Laki-laki</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin ?? '') == 'Perempuan' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="perempuan">Perempuan</label>
                  <div class="invalid-feedback">
                    *Silakan pilih jenis kelamin.
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="tempat_lahir" class="form-label">Tempat Lahir <small class="text-muted">(Wajib diisi)</small></label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                <small class="text-muted">Kota/kabupaten tempat lahir</small>
                <div class="invalid-feedback">*Tempat lahir wajib diisi.</div>
              </div>
              <div class="col-md-6">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <small class="text-muted">(Wajib diisi)</small></label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                <div class="invalid-feedback">*Silakan pilih tanggal lahir.</div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="alamat_domisili" class="form-label">Alamat Domisili <small class="text-muted">(Wajib diisi)</small></label>
            <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="2" required></textarea>
            <small class="text-muted">Alamat tempat tinggal saat ini</small>
            <div class="invalid-feedback">*Alamat domisili wajib diisi.</div>
          </div>

          <div class="mb-3">
            <label for="provinsi" class="form-label">Provinsi Domisili <small class="text-muted">(Wajib diisi)</small></label>
            <select class="form-select" id="provinsi" name="provinsi_id" required>
              <option value="">-- Pilih Provinsi --</option>
              <?php foreach ($provinsi as $prov): ?>
                <option value="<?php echo $prov->id_provinsi; ?>"><?php echo $prov->nama_provinsi; ?></option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">*Silakan pilih provinsi.</div>
          </div>

          <div class="mb-3">
            <label for="kabupaten" class="form-label">Kabupaten/Kota Domisili <small class="text-muted">(Wajib diisi)</small></label>
            <select class="form-select" id="kabupaten" name="kabupaten_id" required>
              <option value="">-- Pilih Kabupaten/Kota --</option>
              <!-- Bisa diisi via AJAX berdasarkan provinsi -->
            </select>
            <div class="invalid-feedback">*Silakan pilih kabupaten/kota.</div>
          </div>


          <div class="mb-3">
            <label for="no_telepon" class="form-label">Nomor Telepon/WhatsApp <small class="text-muted">(Wajib diisi)</small></label>
            <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
            <small class="text-muted">Nomor aktif yang bisa dihubungi</small>
            <div class="invalid-feedback">*Nomor telepon/WhatsApp wajib diisi.</div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email <small class="text-muted">(Opsional)</small></label>
            <input type="email" class="form-control" id="email" name="email">
            <small class="text-muted">Isi hanya jika ingin membuat akun login</small>
            <div class="invalid-feedback">*Silakan masukkan email yang valid.</div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="text-muted">Diperlukan hanya jika mengisi email</small>
            <div class="invalid-feedback">*Silakan masukkan password.</div>
          </div>

          <hr>

          <h4>Data Angkatan</h4>

          <div class="mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="angkatan" class="form-label">Angkatan (Tahun Lulus) <small class="text-muted">(Wajib diisi)</small></label>
                <select name="angkatan" id="angkatan" class="form-select" required>
                  <option value="">-- Pilih Angkatan --</option>
                  <?php
                  $tahun_mulai = 1966;
                  $tahun_sekarang = date('Y');
                  for ($tahun = $tahun_mulai; $tahun <= $tahun_sekarang; $tahun++) {
                    echo '<option value="' . $tahun . '">' . $tahun . '</option>';
                  }
                  ?>
                </select>
                <div class="invalid-feedback">*Silakan pilih angkatan.</div>
              </div>

              <div class="col-md-6">
                <label for="jurusan" class="form-label">Jurusan <small class="text-muted">(Wajib diisi)</small></label>
                <select name="jurusan" id="jurusan" class="form-select" required>
                  <option value="">-- Pilih Jurusan --</option>
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
                <div class="invalid-feedback">*Silakan pilih jurusan.</div>
              </div>
            </div>
          </div>

          <hr>

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
            <small class="text-muted">Pekerjaan saat ini (jika ada)</small>
          </div>

          <div class="mb-3">
            <label for="nama_perusahaan" class="form-label">Nama Perusahaan/Instansi</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan">
            <small class="text-muted">Nama tempat bekerja saat ini</small>
          </div>

          <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan">
            <small class="text-muted">Posisi/jabatan pekerjaan saat ini</small>
          </div>

          <div class="mb-3">
            <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
            <textarea class="form-control" id="alamat_kantor" name="alamat_kantor" rows="2"></textarea>
          </div>

          <hr>

          <div class="mb-3">
            <label for="foto" class="form-label">Foto Profil <small class="text-muted">(Wajib diisi)</small></label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
            <small class="text-muted">Maksimal 10MB (akan otomatis diperkecil oleh sistem, disarankan foto portrait)</small>
            <div class="invalid-feedback">*Silakan upload foto profil.</div>

            <div id="preview-container" class="mt-2" style="display: none;">
              <img id="preview-image" src="#" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
            </div>
          </div>

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

          <input type="hidden" name="referred_by" value="<?php echo $referred_by; ?>">

          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
      </div>
    </div>
  </div>
</div>

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