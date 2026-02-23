<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-6">
  <div class="h-24 w-24 rounded-[2rem] bg-red-50 flex items-center justify-center text-red-600 shadow-xl shadow-red-100 mb-8 border-2 border-red-100 ring-8 ring-red-50/50">
    <i class="fa fa-shield-halved text-4xl"></i>
  </div>
  
  <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Terlarang</h1>
  <p class="mt-4 text-sm text-slate-500 font-bold uppercase tracking-[0.2em] max-w-md mx-auto leading-relaxed">
    Anda tidak memiliki akses ke modul ini.
  </p>

  <div class="mt-12 flex items-center gap-4">
    <a href="<?php echo base_url(); ?>" class="px-8 py-4 bg-blue-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all border-b-4 border-blue-950 active:border-b-0 active:translate-y-1 leading-none">
      Dashboard
    </a>
    <a href="javascript:history.back()" class="px-8 py-4 bg-white text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-sm border border-slate-200 hover:bg-slate-50 transition-all leading-none">
      Batal
    </a>
  </div>

  <div class="mt-16 flex items-center gap-2 opacity-20">
    <div class="h-px w-8 bg-slate-400"></div>
    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none italic">Code 403</span>
    <div class="h-px w-8 bg-slate-400"></div>
  </div>
</div>