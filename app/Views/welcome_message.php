<?php
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>IKA SMANSA / 277 Sinjai</title>
	<link rel="shortcut icon" href="<?php echo base_url("images/logo_ika.ico"); ?>" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo base_url('assets/fontawesome-free/css/all.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>

<body class="h-full flex flex-col items-center justify-center p-6 relative overflow-hidden">

	<!-- Brand Background Accents -->
	<div class="absolute top-0 left-0 w-full h-2 bg-blue-900"></div>
	<div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-900/5 rounded-full blur-[100px]"></div>
	<div class="absolute -bottom-24 -left-24 w-96 h-96 bg-yellow-400/10 rounded-full blur-[100px]"></div>

	<div class="max-w-4xl w-full text-center relative z-10">
		<div class="inline-flex items-center justify-center p-6 bg-white rounded-[3rem] shadow-2xl border border-slate-100 mb-12 transform hover:scale-105 transition-transform duration-500">
			<img class="h-32 w-auto drop-shadow-2xl" src="<?php echo base_url("images/logo_ika1.png") ?>" alt="Logo">
		</div>

		<h1 class="text-5xl md:text-7xl font-black text-blue-900 tracking-[ -0.05em] uppercase italic leading-[0.9]">
			IKA SMANSA /<br>
			<span class="text-yellow-400 drop-shadow-sm italic text-6xl">277 SINJAI</span>
		</h1>

		<p class="mt-8 text-sm md:text-lg text-slate-500 font-bold uppercase tracking-[0.3em] max-w-2xl mx-auto leading-relaxed px-4">
			Ikatan Alumni SMA Negeri 1 Sinjai<br>
			<span class="text-blue-900/40 italic">Membangun Jejaring & Silaturahmi.</span>
		</p>

		<div class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-6">
			<a href="<?php echo site_url('auth/login'); ?>" class="w-full sm:w-auto px-12 py-5 bg-blue-900 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.3em] shadow-2xl shadow-blue-900/30 hover:bg-blue-800 hover:-translate-y-1 transition-all border-b-8 border-blue-950 active:border-b-0 active:translate-y-0">
				Masuk &rarr;
			</a>
			<a href="<?php echo site_url('dashboard'); ?>" class="w-full sm:w-auto px-12 py-5 bg-white text-blue-900 rounded-[2rem] text-xs font-black uppercase tracking-[0.3em] shadow-xl shadow-slate-200 border border-slate-200 hover:bg-slate-50 hover:-translate-y-1 transition-all italic">
				Statistik
			</a>
		</div>

		<div class="mt-24 pt-12 border-t border-slate-200/60 flex flex-col md:flex-row items-center justify-between gap-8">
			<div class="flex items-center gap-4 text-left">
				<div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-900 font-black italic shadow-inner">#</div>
				<div>
					<p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Versi</p>
					<p class="text-xs font-black text-blue-900 uppercase italic">v2.0.26 SaaS</p>
				</div>
			</div>
			<p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">Sinjai, Indonesia</p>
		</div>
	</div>

	<!-- Tooltip -->
	<div class="fixed bottom-8 right-8">
		<div class="bg-white/80 backdrop-blur-md px-4 py-2 rounded-full border border-slate-200 shadow-sm flex items-center gap-2">
			<div class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
			<span class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">Sistem Aktif</span>
		</div>
	</div>

</body>

</html>