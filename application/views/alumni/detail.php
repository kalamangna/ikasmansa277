<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<?php
$user_role = $this->session->userdata('role');
$user_angkatan = $this->session->userdata('angkatan'); // angkatan admin yang login
$alumni_angkatan = $alumni->angkatan; // angkatan alumni yang sedang ditampilkan
$url_pendataan = site_url('alumni/create?ut=' . $this->session->userdata('referral'));

// print_r($alumni);
?>
<div class="row justify-content-center">
  <div class="col-md-9 col-lg-7">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Data Alumni</h3>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-end align-items-center mb-3">
          <?php if ($show_edit): ?>
            <a href="<?= site_url('alumni/edit/' . $alumni->id_alumni) ?>" class="btn btn-secondary">
              Edit
            </a>
          <?php else: ?>
            <!-- <h3>Detail Alumni</h3> -->
          <?php endif; ?>
        </div>

        <!-- 
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#referralModal">
            <i class="fa fa-link"></i> Undang Teman Alumni 
          </button>
        </div>
            -->
        <!-- <h3>Detail Data Alumni</h3> -->

        <p>Terima kasih Anda telah mengisi pendataan alumni.</p>
        <p>Anda adalah Alumni ke <strong><?php echo $urutan_angkatan; ?></strong> dari angkatan <strong><?php echo $alumni->angkatan; ?></strong> yang telah melakukan pendataan.</p>
        <p>Anda adalah Alumni ke <strong><?php echo $urutan_alumni; ?></strong> dari total <strong><?php echo $total_alumni; ?></strong> yang telah melakukan pendataan.</p>

        <!-- Card Data Pribadi -->
        <div class="card mb-3">
          <div class="card-header">
            Data Pribadi
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Nama Lengkap</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->nama_lengkap); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Tempat, Tanggal Lahir</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->tempat_lahir . ', ' . $this->Alumni_model->formatTanggalIndo($alumni->tanggal_lahir)); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Angkatan</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->angkatan); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Nama Panggilan</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->nama_panggilan); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Jenis Kelamin</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->jenis_kelamin); ?></div>
            </div>

            <!-- <p><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($alumni->nama_lengkap); ?></p>
            <p><strong>Tempat, Tanggal Lahir:</strong> <?php echo htmlspecialchars($alumni->tempat_lahir . ', ' . $this->Alumni_model->formatTanggalIndo($alumni->tanggal_lahir)); ?></p>
            <p><strong>Angkatan:</strong> <?php echo htmlspecialchars($alumni->angkatan); ?></p> -->
            <!-- Tambahkan data pribadi lain sesuai kebutuhan -->
            <!-- <p><strong>Nama Panggilan:</strong> <?php echo htmlspecialchars($alumni->nama_panggilan); ?></p>
            <p><strong>Jenis Kelamin:</strong> <?php echo htmlspecialchars($alumni->jenis_kelamin); ?></p> -->
          </div>
        </div>

        <!-- Card Pekerjaan -->
        <div class="card mb-3">
          <div class="card-header">
            Data Pekerjaan
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Nama Pekerjaan</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->nama_pekerjaan); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Nama Perusahaan</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->nama_perusahaan); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Jabatan</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->jabatan); ?></div>
            </div>

            <!-- <p><strong>Nama Pekerjaan:</strong> <?php echo htmlspecialchars($alumni->nama_pekerjaan); ?></p>
            <p><strong>Nama Perusahaan:</strong> <?php echo htmlspecialchars($alumni->nama_perusahaan); ?></p>
            <p><strong>Jabatan:</strong> <?php echo htmlspecialchars($alumni->jabatan); ?></p> -->
            <!-- Tambahkan data pekerjaan lain sesuai kebutuhan -->
          </div>
        </div>

        <!-- Card Alamat -->
        <div class="card mb-3">
          <div class="card-header">
            Alamat
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Alamat Domisili</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->alamat_domisili); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Provinsi</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->provinsi); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Kabupaten</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->kabupaten); ?></div>
            </div>

            <!-- <p><strong>Alamat Domisili:</strong> <?php echo htmlspecialchars($alumni->alamat_domisili); ?></p>
            <p><strong>Provinsi:</strong> <?php echo htmlspecialchars($alumni->provinsi); ?></p>
            <p><strong>Kabupaten:</strong> <?php echo htmlspecialchars($alumni->kabupaten); ?></p> -->
          </div>
        </div>


        <!-- Card Data User -->
        <div class="card mb-3">
          <div class="card-header">Data User</div>
          <div class="card-body">
            <div class="d-flex justify-content-end">
              <?php if (
                $user_role == 'admin' ||
                ($user_role == 'admin_angkatan' && $user_angkatan == $alumni_angkatan)
              ): ?>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal">
                  Edit User
                </button>
              <?php endif; ?>
            </div>

            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Email</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->email); ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-md-4 fw-bold">Role</div>
              <div class="col-md-8"><?php echo htmlspecialchars($alumni->role); ?></div>
            </div>

            <!-- <p><strong>Email:</strong> <?php echo htmlspecialchars($alumni->email); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($alumni->role); ?></p> -->
          </div>
        </div>


        <!-- Jumlah referral -->
        <?php if (count($get_alumni_by_referred_by) > 0): ?>
          <div class="alert alert-info small" role="alert">
            Alumni yang Anda Undang (<?= count($get_alumni_by_referred_by) ?>)</br>
            <?php
            $i = 1;
            foreach ($get_alumni_by_referred_by as $reffered) { ?>
              <a href="<?= base_url('alumni/detail/' . $reffered->id_alumni) ?>"><?= $reffered->nama_lengkap . " (" . $reffered->angkatan . ")" ?><?php if ($i < count($get_alumni_by_referred_by)) {
                                                                                                                                                    echo ",";
                                                                                                                                                  } ?>
              </a>
            <?php
              $i++;
            }
            ?>
          </div>
        <!-- Card Data User -->

        <?php endif; ?>


        <div class="mb-3">
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#undangModal">
                <i class="fa fa-link"></i> Undang Teman Alumni
              </button>
          </div>
        </div>


  <!-- Modal undang teman -->
      <div class="mb-3">
        <div class="modal fade" id="undangModal" tabindex="-1" aria-labelledby="referralModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="referralModalLabel">Link & Undangan WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>
              <div class="modal-body">
                <?php
                $referralLink = base_url('alumni/create?ut=' . $alumni->referral);
                $whatsappMessage = urlencode($referralLink);
                $whatsappLink = "https://wa.me/?text=" . $whatsappMessage;
                ?>

                <p><strong>Link Pendataan Alumni :</strong></p>
                <div class="input-group mb-3">
                  <code class="form-control" id="referralLink"><?php echo $referralLink; ?></code>
                  <button onclick="copyLink('<?php echo htmlspecialchars($referralLink, ENT_QUOTES); ?>')">
                    <i class="fa fa-copy"></i>
                  </button>
                </div>

                <p><strong>Undang via WhatsApp:</strong></p>
                <div class="input-group mb-3">
                  <a href="<?php echo $whatsappLink; ?>" target="_blank" rel="noopener" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> Kirim Undangan WhatsApp
                  </a>
                </div>
                <div class="text-center mb-3">
                  <a href="<?= base_url('qr_code?url=' . $referralLink) ?>"><img width="75%" src="<?= base_url('qr_code?url=' . $referralLink) ?>"></a>
                </div>
              </div>
              <div class="modal-footer">
                <a href="<?php echo $referralLink; ?>" class="btn btn-primary"><i class="fa fa-link"></i> Buka Link</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      </div>



        <!-- Modal link -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form method="post" action="<?php echo site_url('alumni/update_user/' . $alumni->id_alumni); ?>">
                <div class="modal-header">
                  <h5 class="modal-title" id="editUserModalLabel">Edit Data User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($alumni->email); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin ganti)</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                  </div>
                  <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <div class="mb-3">
                      <label for="role" class="form-label">Role User</label>
                      <select class="form-select" id="role" name="role_id" required>
                        <option value="1" <?php echo ($alumni->role_id == '1') ? 'selected' : ''; ?>>Admin</option>
                        <option value="2" <?php echo ($alumni->role_id == '2') ? 'selected' : ''; ?>>Admin Angkatan</option>
                        <option value="5" <?php echo ($alumni->role_id == '5') ? 'selected' : ''; ?>>User</option>
                      </select>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="email_current" value="<?= $alumni->email ?>">
                  <input type="hidden" name="alumni_id" value="<?= $alumni->id_alumni ?>">
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
              </form>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>