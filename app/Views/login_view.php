<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
  <!-- Brand Background Accents -->
  <div class="absolute top-0 left-0 w-full h-1 bg-blue-900"></div>
  <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-blue-900/5 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-yellow-400/10 rounded-full blur-3xl"></div>

  <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
    <div class="flex justify-center">
      <div class="h-20 w-20 bg-white rounded-[2rem] shadow-xl border border-slate-100 flex items-center justify-center p-4">
        <img class="h-full w-auto drop-shadow-sm" src="<?= base_url("images/logo_ika1.png") ?>" alt="Logo">
      </div>
    </div>
    <h2 class="mt-8 text-center text-3xl font-black tracking-tighter text-blue-900 uppercase italic">Masuk</h2>
    <p class="mt-2 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Portal IKA SMANSA / 277 Sinjai</p>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
    <div class="bg-white py-10 px-6 shadow-2xl shadow-blue-900/10 rounded-[2.5rem] border border-slate-200 sm:px-12">
      <form class="space-y-8" action="<?= site_url('auth/login'); ?>" method="POST">
        <?= csrf_field() ?>
        <div>
          <label for="email" class="block text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 mb-2">
            Email
          </label>
          <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-blue-900 transition-colors">
              <i class="fa fa-envelope text-xs"></i>
            </div>
            <input id="email" name="email" type="email" autocomplete="email" required autofocus
              class="block w-full pl-11 pr-4 py-4 bg-slate-50 border-transparent rounded-2xl text-sm font-black text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-4 focus:ring-blue-900/5 focus:border-blue-900 transition-all tracking-tight"
              placeholder="admin@gmail.com">
          </div>
        </div>

        <div>
          <label for="password" class="block text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 mb-2">
            Password
          </label>
          <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-blue-900 transition-colors">
              <i class="fa fa-lock text-xs"></i>
            </div>
            <input id="password" name="password" type="password" autocomplete="current-password" required
              class="block w-full pl-11 pr-4 py-4 bg-slate-50 border-transparent rounded-2xl text-sm font-black text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-4 focus:ring-blue-900/5 focus:border-blue-900 transition-all"
              placeholder="••••••••">
            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 group-focus-within:text-blue-900 transition-colors">
              <i class="fa fa-eye-slash text-xs"></i>
            </button>
          </div>
        </div>

        <div>
          <button type="submit" class="w-full flex justify-center py-4 px-4 border-b-4 border-blue-950 rounded-2xl shadow-xl shadow-blue-900/20 text-[10px] font-black text-white bg-blue-900 hover:bg-blue-800 transition-all uppercase tracking-[0.3em] active:border-b-0 active:translate-y-1">
            Masuk &rarr;
          </button>
        </div>
      </form>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const togglePassword = document.getElementById('togglePassword');
          const password = document.getElementById('password');

          if (togglePassword && password) {
            togglePassword.addEventListener('click', function(e) {
              // toggle the type attribute
              const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
              password.setAttribute('type', type);
              // toggle the eye / eye-slash icon
              this.querySelector('i').classList.toggle('fa-eye');
              this.querySelector('i').classList.toggle('fa-eye-slash');
            });
          }
        });
      </script>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="mt-8 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 flex items-center gap-4">
          <div class="h-8 w-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white flex-shrink-0 shadow-lg">
            <i class="fa fa-check text-xs"></i>
          </div>
          <p class="text-[10px] font-black text-emerald-800 uppercase tracking-widest leading-tight"><?= esc(session()->getFlashdata('success')); ?></p>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="mt-8 rounded-2xl bg-red-50 p-4 border border-red-100 flex items-center gap-4">
          <div class="h-8 w-8 rounded-xl bg-red-600 flex items-center justify-center text-white flex-shrink-0 shadow-lg">
            <i class="fa fa-triangle-exclamation text-xs"></i>
          </div>
          <p class="text-[10px] font-black text-red-800 uppercase tracking-widest leading-tight"><?= esc(session()->getFlashdata('error')); ?></p>
        </div>
      <?php endif; ?>

      <?php if (isset($error)): ?>
        <div class="mt-8 rounded-2xl bg-red-50 p-4 border border-red-100 flex items-center gap-4">
          <div class="h-8 w-8 rounded-xl bg-red-600 flex items-center justify-center text-white flex-shrink-0 shadow-lg shadow-red-200">
            <i class="fa fa-triangle-exclamation text-xs"></i>
          </div>
          <p class="text-[10px] font-black text-red-800 uppercase tracking-widest leading-tight">Gagal: <?= esc($error); ?></p>
        </div>
      <?php endif; ?>
    </div>

    <div class="mt-10 text-center">
      <a href="<?= base_url(); ?>" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 hover:text-blue-900 transition-all uppercase tracking-[0.3em] group">
        <i class="fa fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Beranda
      </a>
    </div>
  </div>
</div>