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
            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
            <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="2" required><?php echo $alumni->alamat_domisili; ?></textarea>
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
                <input type="number" class="form-control" id="angkatan" name="angkatan" min="1900" max="2100" value="<?php echo $alumni->angkatan; ?>" required>

              </div>
              <div class="col-md-6">
                <label for="jurusan" class="form-label">Jurusan (jika ada)</label>
                <!-- <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo $alumni->jurusan; ?>"> -->
                <select name="jurusan" id="jurusan" class="form-select" required>
                  <option value="">-- Pilih Jurusan --</option>
                  <!-- Jurusan SMA -->
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

          <!-- Data Pekerjaan -->
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
    $(document).ready(function() {
      $('#provinsi').change(function() {
        var provinsi_id = $(this).val();
        if (provinsi_id) {
          $.ajax({
            url: '<?php echo site_url('alumni/get_kabupaten_ajax'); ?>',
            type: 'POST',
            data: {
              provinsi_id: provinsi_id
            },
            dataType: 'json',
            success: function(data) {
              $('#kabupaten').empty();
              $('#kabupaten').append('<option value="">-- Pilih Kabupaten/Kota --</option>');
              $.each(data, function(key, value) {
                $('#kabupaten').append('<option value="' + value.id_kabupaten + '">' + value.nama_kabupaten + '</option>');
              });
            }
          });
        } else {
          $('#kabupaten').empty();
          $('#kabupaten').append('<option value="">-- Pilih Kabupaten/Kota --</option>');
        }
      });

      // Jika di form edit, bisa set kabupaten yang sudah dipilih
      <?php if (isset($alumni) && $alumni->kabupaten_id): ?>
        var selectedKabupaten = '<?php echo $alumni->kabupaten_id; ?>';
        var provinsi_id = $('#provinsi').val();
        if (provinsi_id) {
          $.ajax({
            url: '<?php echo site_url('alumni/get_kabupaten_ajax'); ?>',
            type: 'POST',
            data: {
              provinsi_id: provinsi_id
            },
            dataType: 'json',
            success: function(data) {
              $('#kabupaten').empty();
              $('#kabupaten').append('<option value="">-- Pilih Kabupaten/Kota --</option>');
              $.each(data, function(key, value) {
                var selected = (value.id_kabupaten == selectedKabupaten) ? 'selected' : '';
                $('#kabupaten').append('<option value="' + value.id_kabupaten + '" ' + selected + '>' + value.nama_kabupaten + '</option>');
              });
            }
          });
        }
      <?php endif; ?>
    });
  </script>