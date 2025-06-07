<!DOCTYPE html>
<html>
<head>
    <title>Menunggu Waktu Launch</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        #countdown { font-size: 1.2em; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Halaman Pendataan Akan Segera Dibuka</h1>
    <div id="countdown">Waktu tersisa: <span id="time"><?= gmdate("H:i:s", $time_left) ?></span></div>
    <p>Halaman akan otomatis dialihkan ketika waktu launch dimulai.</p>
    
    <script>
    $(document).ready(function() {
        // Format waktu dari detik ke HH:MM:SS
        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            seconds %= 3600;
            const minutes = Math.floor(seconds / 60);
            seconds %= 60;
            
            return [
                hours.toString().padStart(2, '0'),
                minutes.toString().padStart(2, '0'),
                seconds.toString().padStart(2, '0')
            ].join(':');
        }
        
        // Fungsi untuk check status launch
        function checkLaunchStatus() {
            $.getJSON("<?= site_url('launch/check_status') ?>", function(response) {
                if (response.status === 'ready') {
                    window.location.href = response.redirect;
                } else {
                    $('#time').text(formatTime(response.time_left));
                    setTimeout(checkLaunchStatus, 1000);
                }
            }).fail(function() {
                setTimeout(checkLaunchStatus, 1000);
            });
        }
        
        // Mulai pengecekan status
        checkLaunchStatus();
    });
    </script>
</body>
</html>