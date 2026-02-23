<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set Sesi</title>
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>
<body class="h-full flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-blue-900 px-8 py-10 text-center relative overflow-hidden">
            <div class="absolute -right-4 -top-4 opacity-10"><i class="fa fa-cog text-8xl text-white"></i></div>
            <h1 class="text-2xl font-black text-white uppercase italic tracking-tighter relative z-10">Set Sesi</h1>
            <p class="text-[10px] text-blue-300 font-bold mt-2 uppercase tracking-[0.3em] relative z-10">Penjadwalan</p>
        </div>
        
        <div class="p-8 lg:p-10">
            <?php if($session->getFlashdata('success')): ?>
                <div class="mb-8 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 flex items-center gap-4">
                    <div class="h-8 w-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <i class="fa fa-check text-xs"></i>
                    </div>
                    <p class="text-xs font-black text-emerald-800 uppercase tracking-widest leading-tight">Berhasil!</p>
                </div>
            <?php endif; ?>
            
            <form action="<?= site_url('launch/settings') ?>" method="post" class="space-y-8">
                <?= csrf_field() ?>
                <div>
                    <label for="launch_time" class="block text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 mb-3">Waktu Mulai</label>
                    <input type="datetime-local" id="launch_time" name="launch_time" value="<?= !empty($current_setting) ? date('Y-m-d\TH:i', strtotime($current_setting)) : date('Y-m-d\TH:i', time()) ?>" required step="1"
                        class="block w-full px-6 py-4 bg-slate-50 border-slate-200 rounded-2xl text-sm font-black text-slate-900 shadow-inner focus:bg-white focus:ring-4 focus:ring-blue-900/5 focus:border-blue-900 transition-all uppercase tabular-nums">
                </div>
                
                <button type="submit" class="w-full inline-flex justify-center rounded-2xl bg-blue-900 px-8 py-5 text-[10px] font-black text-white shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all uppercase tracking-[0.3em] border-b-4 border-blue-950 active:border-b-0 active:translate-y-1">
                    Simpan
                </button>
            </form>
            
            <?php if(!empty($current_setting)): ?>
            <div class="mt-10 pt-10 border-t border-slate-100 space-y-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px flex-1 bg-slate-100"></div>
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic">Detail Sesi</p>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>
                
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Mulai</span>
                        <span class="text-xs font-black text-blue-900 italic tabular-nums"><?= date('H:i:s', strtotime($current_setting)) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Durasi</span>
                        <span class="text-xs font-black text-slate-700 italic uppercase">120 DETIK</span>
                    </div>
                    <div class="pt-3 border-t border-slate-200/60 flex justify-between items-center">
                        <span class="text-[9px] font-black text-red-600 uppercase tracking-widest">Selesai</span>
                        <span class="text-xs font-black text-red-600 italic tabular-nums"><?= date('H:i:s', strtotime($current_setting) + 120) ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="bg-slate-50 px-10 py-6 border-t border-slate-100 text-center">
            <p class="text-[8px] font-black text-slate-300 uppercase tracking-[0.5em] italic leading-none">Admin Only</p>
        </div>
    </div>
</body>
</html>