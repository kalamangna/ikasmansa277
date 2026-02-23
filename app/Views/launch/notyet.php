<div class="min-h-screen bg-slate-50 flex flex-col items-center justify-center p-6 text-center">
    <div class="mb-12 inline-flex items-center justify-center p-6 bg-white rounded-[3rem] shadow-2xl border border-slate-100">
        <img class="h-24 w-auto grayscale opacity-20" src="<?php echo base_url("images/ika.png") ?>" alt="Logo">
    </div>

    <div class="h-24 w-24 rounded-[2rem] bg-blue-50 flex items-center justify-center text-blue-900 shadow-xl shadow-blue-100 mb-10 border-2 border-blue-100 ring-8 ring-blue-50/50">
        <i class="fa fa-hourglass-start text-4xl italic animate-pulse"></i>
    </div>
    
    <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Standby</h1>
    <p class="mt-6 text-sm text-slate-500 font-bold uppercase tracking-[0.3em] max-w-md mx-auto leading-relaxed italic">
        Sesi belum diaktifkan oleh admin.
    </p>

    <div class="mt-16">
        <button onclick="location.reload()" class="inline-flex items-center gap-x-4 px-12 py-5 bg-blue-900 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.3em] shadow-2xl shadow-blue-900/30 hover:bg-blue-800 transition-all border-b-8 border-blue-950 active:border-b-0 active:translate-y-1 group leading-none">
            <i class="fas fa-sync group-hover:rotate-180 transition-transform duration-700 text-yellow-400"></i>
            Refresh
        </button>
    </div>

    <div class="mt-20 flex items-center gap-3">
        <div class="h-px w-12 bg-slate-200"></div>
        <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.5em] leading-none italic">Menunggu Sinyal...</span>
        <div class="h-px w-12 bg-slate-200"></div>
    </div>
</div>