<?php
$is_logged_in = $this->session->userdata('logged_in');
$is_admin = $this->session->userdata('role') == 'admin' ? 1 : null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Primary Meta Tags -->
  <title>IKA SMANSA / 277 Sinjai</title>
  <meta name="title" content="IKA SMANSA / 277 Sinjai  - Pendataan Alumni" />
  <meta name="description" content="" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?php echo base_url(); ?>" />
  <meta property="og:title" content="IKA SMANSA / 277 Sinjai - Pendataan Alumni" />
  <meta property="og:description" content="" />
  <meta property="og:image" content="<?php echo base_url("meta.jpeg"); ?>" />

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image" />
  <meta property="twitter:url" content="<?php echo base_url(); ?>" />
  <meta property="twitter:title" content="IKA SMANSA / 277 Sinjai - Pendataan Alumni" />
  <meta property="twitter:description" content="" />
  <meta property="twitter:image" content="<?php echo base_url("meta.jpeg"); ?>" />

  <!-- Meta Tags Generated with https://metatags.io -->
  <link rel="shortcut icon" href="<?php echo base_url("images/logo_ika.ico"); ?>" type="image/x-icon">

  <title>IKA SMANSA / 277 Sinjai</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/fontawesome-free/css/all.min.css') ?>">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/sb-admin-2.min.css') ?>">


  <script>
    function copyLink(link) {
      navigator.clipboard.writeText(link).catch(err => console.error("Gagal menyalin:", err));
    }
  </script>
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="http://ikasmansa277.id">
        <img src="<?php echo base_url("images/logo_ika1.png") ?>" alt="Logo IKA" width="30" height="30" class="d-inline-block align-text-top">
        <span class="ms-1">IKA SMANSA / 277 Sinjai</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
          </li>

          <?php if ($is_logged_in and !empty($this->session->userdata('referral'))): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('alumni'); ?>">Data Alumni</a>
            </li>
          <?php endif; ?>
        </ul>

        <!-- Menu login/logout di sebelah kanan -->
        <ul class="navbar-nav ml-auto">
          <?php if ($is_logged_in): ?>
            <?php if (!empty($this->session->userdata('referral'))): ?>
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#referralModal">
                  <i class="fa fa-link"></i> Undang Teman Alumni
                </button>
              </div>
            <?php endif; ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Halo, <?php echo $this->session->userdata('nama_lengkap'); ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo site_url('alumni/detail/' . $this->session->userdata('id_alumni')); ?>"><i class="fa fa-link"></i> Profil User</a>
                <a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>">Logout</a>
                <!-- <a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>">Logout</a> -->
              </div>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('auth/login'); ?>">Login</a>
            </li>
          <?php endif; ?>
        </ul>

      </div>
    </div>
  </nav>
  <div class="container mt-4" style="min-height: 100vh;">


    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>




    <?php
    // print_r($this->session->userdata())
    ?>





    <!-- Modal link -->
    <?php if ($is_logged_in): ?>
      <div class="mb-3">
        <div class="modal fade" id="referralModal" tabindex="-1" aria-labelledby="referralModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="referralModalLabel">Link & Undangan WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>
              <div class="modal-body">
                <?php
                $referralLink = base_url('alumni/create?ut=' . $this->session->userdata('referral'));
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
    <?php endif; ?>