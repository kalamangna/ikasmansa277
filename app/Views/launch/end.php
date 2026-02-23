<div class="min-h-screen bg-slate-50 flex flex-col items-center justify-center p-6 text-center">
    <div class="mb-12 inline-flex items-center justify-center p-6 bg-white rounded-[3rem] shadow-2xl border border-slate-100">
        <img class="h-24 w-auto grayscale opacity-20" src="<?php echo base_url("images/logo_ika1.png") ?>" alt="Logo">
    </div>

    <div class="h-24 w-24 rounded-[2rem] bg-red-50 flex items-center justify-center text-red-600 shadow-xl shadow-red-100 mb-10 border-2 border-red-100 ring-8 ring-red-50/50">
        <i class="fa fa-clock text-4xl italic"></i>
    </div>
    
    <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Selesai</h1>
    <p class="mt-6 text-sm text-slate-500 font-bold uppercase tracking-[0.3em] max-w-md mx-auto leading-relaxed italic">
        Sesi pendataan telah berakhir.
    </p>

    <div class="mt-16">
        <a href="<?=base_url()?>" class="inline-flex items-center gap-x-4 px-12 py-5 bg-blue-900 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.3em] shadow-2xl shadow-blue-900/30 hover:bg-blue-800 transition-all border-b-8 border-blue-950 active:border-b-0 active:translate-y-1 group leading-none">
            <i class="fas fa-rotate group-hover:rotate-180 transition-transform duration-700 text-yellow-400"></i>
            Beranda
        </a>
    </div>

    <div class="mt-20 flex items-center gap-3">
        <div class="h-px w-12 bg-slate-200"></div>
        <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.5em] leading-none italic">Status: Offline</span>
        <div class="h-px w-12 bg-slate-200"></div>
    </div>
</div>