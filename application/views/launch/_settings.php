<!DOCTYPE html>
<html>
<head>
    <title>Pengaturan Waktu Launch</title>
    <style>
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="datetime-local"] { padding: 8px; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Pengaturan Waktu Launch</h1>
    
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>
    
    <form action="<?= site_url('launch/settings') ?>" method="post">
        <div class="form-group">
            <label for="launch_time">Waktu Launch:</label>

            <input type="datetime-local" id="launch_time" name="launch_time" value="<?= !empty($current_setting) ? date('Y-m-d\TH:i', strtotime($current_setting)) : date('Y-m-d\TH:i', time()) ?>" required step="1">
        </div>
        
        <button type="submit">Simpan Pengaturan</button>
    </form>
    
    <?php if(!empty($current_setting)): ?>
    <div style="margin-top: 20px;">
        <h3>Informasi Launch:</h3>
        <p>Waktu Launch: <?= date('d F Y H:i:s', strtotime($current_setting)) ?></p>
        <p>Durasi: 2 menit</p>
        <p>Halaman Pendataan akan aktif dari:<br>
           <?= date('d F Y H:i:s', strtotime($current_setting)) ?> sampai 
           <?= date('d F Y H:i:s', strtotime($current_setting) + 120) ?></p>
    </div>
    <?php endif; ?>
</body>
</html>