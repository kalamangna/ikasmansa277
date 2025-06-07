<!DOCTYPE html>
<html>
<head>
    <title>Kontrol Pendataan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="container text-center py-5">
        <h1 class="display-4 mb-4">SISTEM PENDATAAN ONLINE</h1>
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if(!$launch_data): ?>
            <form action="<?= site_url('launch/control') ?>" method="post">
                <button type="submit" value="1" name="start_launch" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow my-4 position-relative overflow-hidden">
                    <span class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-25 rounded-pill animate-pulse"></span>
                    <i class="fas fa-rocket me-2"></i> MULAI PENDATAAN
                </button>
                <p class="fs-5 text-muted">Klik tombol di atas untuk memulai proses pendataan selama <?=$duration/60?> menit</p>
            </form>
        <?php else: ?>
            <div class="card shadow-lg p-4 mb-5 bg-white rounded-3">
                <div class="card-body">
                    <h2 class="card-title mb-4">STATUS PENDATAAN</h2>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Status:</span>
                        <span class="badge bg-primary fs-6">
                        <?php 
                        $current_time = time();
                        $start_time = strtotime($launch_data->start_time);
                        $end_time = $start_time + $duration;
                        
                        if($current_time < $start_time) {
                            echo "MENUNGGU DIMULAI";
                        } elseif($current_time >= $start_time && $current_time <= $end_time) {
                            echo "SEDANG BERLANGSUNG";
                        } else {
                            echo "SELESAI";
                        }
                        ?>
                        </span>
                    </div>

                    <?php
                    $url_pendataan = base_url('/launch');
                    $whatsappMessage = urlencode($url_pendataan);
                    ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Link Pendataan Alumni:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?= $url_pendataan ?>" id="referralLink" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyLink('<?= htmlspecialchars($url_pendataan, ENT_QUOTES) ?>')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <a href="<?= base_url('qr_code?url=' . $url_pendataan) ?>">
                            <img src="<?= base_url('qr_code?url=' . $url_pendataan) ?>" class="img-fluid" style="max-width: 200px;">
                        </a>


                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Waktu Mulai:</span>
                        <span><?= date('d F Y H:i:s', strtotime($launch_data->start_time)) ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold">Waktu Berakhir:</span>
                        <span><?= date('d F Y H:i:s', strtotime($launch_data->start_time) + $duration) ?></span>
                    </div>
                    
                    <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                        <a href="<?= site_url('launch') ?>" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-external-link-alt me-2"></i> LIHAT HALAMAN PENDATAAN
                        </a>
                        <a href="<?= site_url('launch/control/reset') ?>" class="btn btn-danger px-4 py-2">
                            <i class="fas fa-sync-alt me-2"></i> RESET PENDATAAN
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function copyLink(link) {
        navigator.clipboard.writeText(link);
        alert('Link berhasil disalin!');
    }
    
    // Simple pulse animation
    const animatePulse = () => {
        const pulse = document.querySelector('.animate-pulse');
        if (pulse) {
            pulse.style.animation = 'pulse 2s infinite';
        }
    };
    
    document.addEventListener('DOMContentLoaded', animatePulse);
    </script>
    <style>
    @keyframes pulse {
        0% { transform: scale(0.9); opacity: 1; }
        100% { transform: scale(1.3); opacity: 0; }
    }
    </style>
</body>
</html>