<!-- <img src="<?= site_url('qrcode_test/generate/' . urlencode($url)) ?>" alt="QR Code"> -->
<h2 class="mb-4">Daftar Alumni Pendataan</h2>

<div class="card shadow">
  <div class="card-header">
    <?php if ($user_role == 'admin'): ?>
      <form method="get" class="mb-3">
        <label for="angkatan" class="form-label">Pilih Angkatan:</label>
        <select name="angkatan" id="angkatan" class="form-select" onchange="this.form.submit()">
          <?php foreach ($angkatan_list as $angk): ?>
            <option value="<?php echo $angk['angkatan']; ?>" <?php echo ($selected_angkatan == $angk['angkatan']) ? 'selected' : ''; ?>>
              <?php echo $angk['angkatan']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </form>
    <?php else: ?>
      <p class="mb-0"><strong>Angkatan Anda:</strong> <?php echo htmlspecialchars($selected_angkatan); ?></p>
    <?php endif; ?>
  </div>

  <div class="card-body">
    <div class="table-responsive py-2">
      <table class="table table-bordered table-striped text-nowrap align-middle" id="alumniTable">
        <thead>
          <tr>
            <th>No.</th>
            <th class="text-center">Nama Lengkap</th>
            <th class="text-center">Nama Panggilan</th>
            <th class="text-center">Jurusan</th>
            <th class="text-center">Domisili Sekarang</th>
            <th class="text-center">Ref</th>
            <?php if ($is_admin) { ?>
              <th class="text-center">Proses</th>
            <?php } ?>

            <!-- Tambahkan kolom lain sesuai kebutuhan -->
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($alumni_list)): ?>
            <?php $no = 1;
            foreach ($alumni_list as $alumni): ?>
              <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($alumni->nama_lengkap); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($alumni->nama_panggilan); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($alumni->jurusan); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($alumni->provinsi . " / " . $alumni->kabupaten); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($alumni->ref_jumlah); ?></td>
                <?php if ($is_admin): ?>
                  <td class="text-center">
                    <a href="<?= site_url('alumni/detail/' . $alumni->id_alumni) ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-info"></i></a>

                    <?php if ($alumni->id_alumni !=  $this->session->userdata('id_alumni') && $alumni->ref_jumlah == 0): ?>
                      <a href="<?= site_url('alumni/hapus/' . $alumni->id_alumni) ?>" class="btn btn-outline-danger btn-sm ms-2" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center">Data tidak ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
// print_r($alumni_list);
?>