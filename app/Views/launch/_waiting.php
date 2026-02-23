<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menunggu</title>
    <link rel="shortcut icon" href="<?php echo base_url("images/ika.png"); ?>" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script src="<?php echo base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
</head>
<body class="h-full flex flex-col items-center justify-center p-6 text-center">
    
    <!-- Background -->
    <div class="absolute top-0 left-0 w-full h-2 bg-blue-900"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-900/5 rounded-full blur-[100px]"></div>

    <div class="mb-12 inline-flex items-center justify-center p-6 bg-white rounded-[3rem] shadow-2xl border border-slate-100 transform hover:rotate-3 transition-transform">
        <img class="h-24 w-auto" src="<?php echo base_url("images/ika.png") ?>" alt="Logo">
    </div>

    <div class="bg-white rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border border-slate-200 p-12 max-w-lg w-full relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1.5 bg-yellow-400"></div>
        
        <div class="h-20 w-20 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-900 shadow-inner mb-8 mx-auto ring-1 ring-blue-100">
            <i class="fa fa-satellite-dish text-3xl animate-bounce"></i>
        </div>

        <h1 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter leading-none mb-4">Menunggu</h1>
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.3em] mb-10 leading-relaxed italic px-4 text-center">
            Sinkronisasi data...<br>Pendaftaran akan terbuka otomatis.
        </p>

        <div class="bg-slate-900 rounded-3xl p-8 mb-8 shadow-2xl border-b-4 border-yellow-400">
            <p class="text-[9px] font-black text-blue-300 uppercase tracking-[0.4em] mb-4 leading-none">Hitung Mundur</p>
            <p class="text-5xl font-black text-white tabular-nums tracking-tighter italic leading-none" id="time"><?= gmdate("H:i:s", $time_left) ?></p>
        </div>

        <div class="flex items-center justify-center gap-3">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Terhubung</span>
        </div>
    </div>

    <div class="mt-16 flex items-center gap-3 opacity-20">
        <div class="h-px w-12 bg-slate-400"></div>
        <span class="text-[8px] font-black text-slate-500 uppercase tracking-[0.5em] leading-none italic">SaaS Edition</span>
        <div class="h-px w-12 bg-slate-400"></div>
    </div>

    <script>
    $(document).ready(function() {
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
        checkLaunchStatus();
    });
    </script>
</body>
</html>