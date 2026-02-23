<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IKA SMANSA / 277 Sinjai | Kontrol</title>
    <link rel="shortcut icon" href="<?= base_url("images/logo_ika.ico"); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>
<body class="h-full flex items-center justify-center p-6 relative overflow-hidden font-sans">
    
    <!-- Background -->
    <div class="absolute inset-0 bg-blue-900 overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-800 transform skew-x-12 translate-x-32 shadow-2xl opacity-50"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-yellow-400 rounded-full blur-[120px] opacity-10"></div>
    </div>

    <div class="max-w-4xl w-full relative z-10">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center p-4 bg-white rounded-3xl shadow-2xl mb-8 ring-8 ring-white/10">
                <img src="<?= base_url("images/logo_ika1.png") ?>" class="h-16 w-auto" alt="Logo">
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase italic leading-none">Kontrol Sesi</h1>
            <p class="text-[10px] text-blue-300 font-bold mt-4 uppercase tracking-[0.4em] italic">Manajemen Pendaftaran</p>
        </div>
        
        <?php if($session->getFlashdata('success')): ?>
            <div class="mb-8 rounded-3xl bg-emerald-500/10 backdrop-blur-md p-6 border border-emerald-500/20 flex items-center gap-5 shadow-2xl">
                <div class="h-12 w-12 rounded-2xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                    <i class="fa fa-check-double text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest leading-none mb-1">Berhasil</p>
                    <p class="text-sm font-bold text-white"><?= esc($session->getFlashdata('success')) ?></p>
                </div>
                <button type="button" class="text-emerald-400/50 hover:text-emerald-400 transition-colors" data-close-alert>
                    <i class="fa fa-times-circle text-xl"></i>
                </button>
            </div>
        <?php endif; ?>
        
        <?php if(!$launch_data): ?>
            <div class="bg-white/5 backdrop-blur-xl rounded-[3rem] p-12 border border-white/10 shadow-2xl text-center">
                <form action="<?= site_url('launch/control') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" value="1" name="start_launch" class="group relative bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-black text-2xl py-8 px-16 rounded-[2rem] shadow-2xl shadow-yellow-400/20 mb-10 overflow-hidden transition-all transform hover:-translate-y-2 active:scale-95 border-b-8 border-yellow-600">
                        <span class="absolute inset-0 bg-white/20 animate-pulse group-hover:animate-none"></span>
                        <i class="fas fa-rocket mr-4 italic transition-transform"></i>
                        MULAI
                    </button>
                    <div class="flex flex-col items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-px w-8 bg-blue-400/30"></div>
                            <p class="text-sm font-black text-blue-100 uppercase tracking-[0.2em] italic">Konfigurasi</p>
                            <div class="h-px w-8 bg-blue-400/30"></div>
                        </div>
                        <p class="text-xs font-bold text-blue-300/60 uppercase tracking-widest leading-relaxed px-12">
                            Klik tombol di atas untuk membuka pendaftaran publik<br>
                            selama <span class="text-yellow-400"><?= (int)$duration/60 ?> menit</span>.
                        </p>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border border-slate-200 overflow-hidden">
                <div class="px-12 py-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6 pb-8 border-b border-slate-100">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 uppercase italic leading-none">Status Sesi</h2>
                            <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-widest italic">Monitoring Aliran Data</p>
                        </div>
                        
                        <div class="inline-flex items-center gap-x-3 bg-blue-900 px-6 py-3 rounded-2xl shadow-xl shadow-blue-900/20 ring-4 ring-blue-100">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-400"></span>
                            </span>
                            <span class="text-xs font-black text-white uppercase tracking-[0.2em]">
                            <?php 
                            $current_time = time();
                            $start_time = strtotime($launch_data->start_time);
                            $end_time = $start_time + (int)$duration;
                            
                            if($current_time < $start_time) {
                                echo "STANDBY";
                            } elseif($current_time >= $start_time && $current_time <= $end_time) {
                                echo "AKTIF";
                            } else {
                                echo "SELESAI";
                            }
                            ?>
                            </span>
                        </div>
                    </div>

                    <?php
                    $url_pendataan = base_url('/launch');
                    ?>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-12">
                        <div class="lg:col-span-7 space-y-8">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1">Link Daftar</label>
                                <div class="flex p-1.5 bg-slate-50 rounded-2xl ring-1 ring-slate-200 shadow-inner">
                                    <input type="text" class="block w-full border-0 bg-transparent py-3 px-4 text-blue-900 text-xs font-black font-mono focus:ring-0 uppercase" value="<?= esc($url_pendataan) ?>" id="referralLink" readonly>
                                    <button class="bg-blue-900 hover:bg-blue-800 text-yellow-400 p-3 rounded-xl shadow-lg transition-all active:scale-95" type="button" onclick="copyLink('<?= esc($url_pendataan) ?>')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 pt-4">
                                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm group hover:border-blue-900 transition-colors text-center">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-3 italic">Mulai</p>
                                    <p class="text-sm font-black text-slate-800 tabular-nums italic leading-none"><?= date('H:i:s', strtotime($launch_data->start_time)) ?></p>
                                    <p class="text-[9px] font-bold text-slate-300 mt-2 uppercase"><?= date('d M Y', strtotime($launch_data->start_time)) ?></p>
                                </div>
                                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm group hover:border-red-600 transition-colors text-center">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-3 italic">Selesai</p>
                                    <p class="text-sm font-black text-slate-800 tabular-nums italic leading-none"><?= date('H:i:s', strtotime($launch_data->start_time) + (int)$duration) ?></p>
                                    <p class="text-[9px] font-bold text-slate-300 mt-2 uppercase"><?= date('d M Y', strtotime($launch_data->start_time)) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-5 flex flex-col items-center">
                            <div class="p-4 bg-white rounded-[2.5rem] border-4 border-slate-50 shadow-2xl relative group">
                                <div class="absolute -inset-2 bg-gradient-to-tr from-blue-900 to-yellow-400 rounded-[2.8rem] opacity-10 group-hover:opacity-20 transition-opacity blur-lg"></div>
                                <img src="<?= base_url('qr_code?url=' . urlencode($url_pendataan)) ?>" class="relative h-48 w-48 rounded-[2rem] shadow-inner">
                            </div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mt-8 italic leading-none">Scan QR</p>
                        </div>
                    </div>
                    
                    <div class="pt-10 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-6">
                        <a href="<?= site_url('launch') ?>" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-5 rounded-2xl bg-blue-900 text-white text-[10px] font-black uppercase tracking-[0.3em] shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all border-b-4 border-blue-950 active:border-b-0 active:translate-y-1 group leading-none">
                            <i class="fas fa-external-link-alt mr-3 text-yellow-400 group-hover:rotate-12 transition-transform"></i> LIHAT HALAMAN
                        </a>
                        <a href="<?= site_url('launch/control/reset') ?>" onclick="return confirm('Reset sesi?')" class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-5 rounded-2xl bg-white text-red-600 text-[10px] font-black uppercase tracking-[0.3em] shadow-lg shadow-red-100 border border-red-100 hover:bg-red-50 transition-all group leading-none">
                            <i class="fas fa-power-off mr-3 group-hover:scale-110 transition-transform"></i> RESET
                        </a>
                    </div>
                </div>
                <div class="bg-slate-50 px-12 py-6 border-t border-slate-100 text-center">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.5em] italic leading-none">Mode Admin</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function copyLink(link) {
        navigator.clipboard.writeText(link).then(() => {
            alert('Link disalin!');
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const dismissButtons = document.querySelectorAll('[data-close-alert]');
        dismissButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alertDiv = button.closest('[role="alert"]') || button.closest('.mb-8');
                if (alertDiv) {
                    alertDiv.style.opacity = '0';
                    setTimeout(() => alertDiv.remove(), 300);
                }
            });
        });
    });
    </script>
</body>
</html>