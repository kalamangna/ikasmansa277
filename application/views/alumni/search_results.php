<div class="container mt-4">
    <!-- Judul dengan informasi pencarian -->
    <h2 class="mb-4">Hasil Pencarian untuk "<?php echo htmlspecialchars($keyword); ?>"</h2>
    
    <!-- Tombol kembali -->
      <a href="<?php echo site_url('dashboard'); ?>" onclick="if(history.length > 1){window.history.back(); return false;}" class="btn btn-primary mb-4">
          <i class="fas fa-arrow-left"></i> Kembali ke Halaman Sebelumnya
      </a>

    <div class="card shadow">
        <div class="card-header">
            <p class="mb-0"><strong>Total Ditemukan:</strong> <?php echo count($results); ?> alumni</p>
        </div>

        <div class="card-body">
            <div class="table-responsive py-2">
                <table class="table table-bordered table-striped text-nowrap align-middle" id="searchTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">Nama Panggilan</th>
                            <th class="text-center">Angkatan</th>
                            <th class="text-center">Jurusan</th>
                            <th class="text-center">Domisili Sekarang</th>
                            <th class="text-center">Ref</th>
                            <?php if ($is_admin) { ?>
                                <th class="text-center">Proses</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($results)): ?>
                            <?php $no = 1;
                            foreach ($results as $alumni): ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($alumni->nama_lengkap); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($alumni->nama_panggilan ?? '-'); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($alumni->angkatan); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($alumni->jurusan); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($alumni->provinsi . " / " . $alumni->kabupaten); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($alumni->ref_jumlah); ?></td>
                                    <?php if ($is_admin): ?>
                                        <td class="text-center">
                                            <a href="<?= site_url('alumni/detail/' . $alumni->id_alumni) ?>" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-info"></i>
                                            </a>

                                            <?php if (isset($alumni->id_alumni) && $alumni->id_alumni != $this->session->userdata('id_alumni') && $alumni->ref_jumlah == 0): ?>
                                                <a href="<?= site_url('alumni/hapus/' . $alumni->id_alumni) ?>" class="btn btn-outline-danger btn-sm ms-2" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?php echo ($is_admin) ? '8' : '7'; ?>" class="text-center">Tidak ditemukan alumni dengan nama tersebut</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>