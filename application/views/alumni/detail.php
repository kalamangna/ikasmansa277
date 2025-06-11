<!--  -->
<?php

// print_r($this->session->userdata());
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
        <div class="row">

          <div class="col-md-6">
            <h3 class="">Data Alumni</h3>
          </div>
          <div class="col-md-6 d-flex justify-content-end align-items-center">
            <?php if ($show_edit): ?>
              <a href="<?= site_url('alumni/edit/' . $alumni->id_alumni) ?>" class="btn btn-warning">
                Edit
              </a>
            <?php else: ?>
              <!-- <h3>Detail Alumni</h3> -->
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="card-body">

        <div class="card mb-3">
          <div class="card-body">

            <!-- <p>Terima kasih <strong class="text-bold"><?php echo htmlspecialchars($alumni->nama_lengkap); ?> </strong> angkatan <strong class="text-bold"><?= $alumni->angkatan ?> </strong> telah berpartisipasi di Pendataan&nbsp;Alumni&nbsp;SMAN&nbsp;1/277&nbsp;Sinjai.</p>
            <p>Anda adalah Alumni ke <strong><?php echo $urutan_angkatan; ?></strong> dari <strong><?php echo $total_angkatan; ?></strong> alumni angkatan <strong><?php echo $alumni->angkatan; ?></strong> yang telah melakukan pendataan.</p>
            <p>Anda adalah Alumni ke <strong><?php echo $urutan_alumni; ?></strong> dari total <strong><?php echo $total_alumni; ?></strong> yang telah melakukan pendataan.</p> -->

            <p>
              Terima kasih
              <strong class="fw-bold text-primary">
                <?= htmlspecialchars($alumni->nama_lengkap); ?>
              </strong>
              angkatan
              <strong class="fw-bold text-success">
                <?= $alumni->angkatan; ?>
              </strong>
              telah berpartisipasi dalam <span class="fst-italic">Pendataan Alumni SMAN 1/277 Sinjai</span>.
            </p>

            <p>
              Anda adalah alumni ke-
              <strong class="fw-bold text-danger">
                <?= $urutan_angkatan; ?>
              </strong>
              dari
              <strong class="fw-bold text-danger">
                <?= $total_angkatan; ?>
              </strong>
              alumni angkatan
              <strong class="fw-bold text-success">
                <?= $alumni->angkatan; ?>
              </strong>
              yang telah melakukan pendataan.
            </p>

            <p>
              Secara keseluruhan, Anda adalah alumni ke-
              <strong class="fw-bold text-danger">
                <?= $urutan_alumni; ?>
              </strong>
              dari total
              <strong class="fw-bold text-danger">
                <?= $total_alumni; ?>
              </strong>
              alumni yang telah terdata.
            </p>


            <!-- Foto Profil Section -->
            <div class="text-center mb-4">
              <div class="profile-photo-container" style="width: 150px; height: 150px; margin: 0 auto; border-radius: 50%; overflow: hidden; border: 3px solid #f0f0f0;">
                <?php if (!empty($alumni->foto_profil)): ?>
                  <img src="<?= base_url('uploads/foto_alumni/' . $alumni->foto_profil) ?>" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                  <div style="width: 100%; height: 100%; background-color: #ddd; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="font-size: 60px; color: #777;"></i>
                  </div>
                <?php endif; ?>
              </div>

              <?php if ($show_edit): ?>
                <div class="mt-3">
                  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                    <i class="fas fa-camera"></i> Ganti Foto
                  </button>
                </div>
              <?php endif; ?>
            </div>

            <small class=" d-flex justify-content-end align-items-center">
              <?= "created_at : " . $alumni->created_at ?><?= $alumni->created_at != $alumni->updated_at ? "<br/>update_at : " . $alumni->updated_at : "" ?>
            </small>
          </div>
        </div>


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
          </div>
        </div>

        <!-- Jumlah referred by -->
        <?php
        $referral = $this->Alumni_model->get_alumni($alumni->referred_by);
        ?>
        <?php if (!empty($alumni->referred_by)): ?>
          <div class="alert alert-info small" role="alert">
            Referred by :
            <?php if (
              $user_role == 'admin' ||
              ($user_role == 'admin_angkatan' && $user_angkatan == $alumni_angkatan)
            ): ?>
              <a href="<?= base_url('alumni/detail/' . $referral->id_alumni) ?>">
                <?= $referral->nama_lengkap . " (" . $referral->angkatan . ")"; ?>
              </a>
            <?php else: ?>
              <?= $referral->nama_lengkap . " (" . $referral->angkatan . ")"; ?>
            <?php endif;  ?>
          </div>
        <?php endif;  ?>

        <!-- Jumlah referral -->
        <?php if (count($get_alumni_by_referred_by) > 0): ?>
          <div class="alert alert-info small" role="alert">
            Alumni yang Anda Undang (<?= count($get_alumni_by_referred_by) ?>)</br>
            <?php
            $i = 1;
            foreach ($get_alumni_by_referred_by as $reffered) { ?>
              <?php if (
                $user_role == 'admin' ||
                ($user_role == 'admin_angkatan' && $user_angkatan == $alumni_angkatan)
              ): ?>
                <a href="<?= base_url('alumni/detail/' . $reffered->id_alumni) ?>"><?= $reffered->nama_lengkap . " (" . $reffered->angkatan . ")" ?><?php if ($i < count($get_alumni_by_referred_by)) {
                                                                                                                                                      echo ",";
                                                                                                                                                    } ?>
                </a>
              <?php else: ?>
                <?= $reffered->nama_lengkap . " (" . $reffered->angkatan . ")" ?>
              <?php endif; ?>
            <?php
              $i++;
            }
            ?>
          </div>
        <?php endif; ?>

        <div class="mb-3">
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#referralModal">
              <i class="fa fa-link"></i> Undang Teman Alumni melalui akun ini
            </button>
          </div>
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
            <form method="post" action="<?php echo site_url('alumni/update_user/' . $alumni->id_alumni); ?>" class="needs-validation" novalidate>
              <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>

              <div class="modal-body">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($alumni->email); ?>" required>
                  <div class="invalid-feedback">*Silakan masukkan email yang valid.</div>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin ganti)</label>
                  <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                </div>

                <?php if ($this->session->userdata('role') == 'admin'): ?>
                  <div class="mb-3">
                    <label for="role" class="form-label">Role User</label>
                    <select class="form-select" id="role" name="role_id" required>
                      <option>-Pilih Role-</option>
                      <?php if ($user_role == 'admin'): ?>
                        <option value="1" <?php echo ($alumni->role_id == '1') ? 'selected' : ''; ?>>Admin</option>
                        <option value="2" <?php echo ($alumni->role_id == '2') ? 'selected' : ''; ?>>Admin Angkatan</option>
                      <?php endif; ?>
                      <option value="5" <?php echo ($alumni->role_id == '5') ? 'selected' : ''; ?>>User Alumni</option>
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


<!-- Modal Upload Foto -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= site_url('alumni/upload_photo/' . $alumni->id_alumni) ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-header">
          <h5 class="modal-title" id="uploadPhotoModalLabel">Unggah Foto Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="foto_profil" class="form-label">Pilih Foto</label>
            <input class="form-control" type="file" id="foto_profil" name="foto_profil" accept="image/*" required>
            <small class="text-muted">Maksimal 10MB (akan otomatis diperkecil oleh sistem, disarankan foto portrait)</small>
            <div class="invalid-feedback">*Silakan upload foto profil.</div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Unggah</button>
        </div>
      </form>
    </div>
  </div>
</div>















<script>
  function copyLink(link) {
    navigator.clipboard.writeText(link).then(function() {
      alert('Link berhasil disalin!');
    }, function() {
      alert('Gagal menyalin link');
    });
  }
</script>