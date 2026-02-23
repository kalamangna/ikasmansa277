<?php
$session = session();
$is_logged_in = $session->get('logged_in');
$is_admin = $session->get('role') == 'admin' ? 1 : null;

/**
 * Helper function to check if a menu item is active
 * Using CI4 url_is() helper for cleaner logic
 */
function is_active_menu_ci4($path)
{
  return url_is($path . '*') ? true : false;
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Portal Alumni') ?> - IKA SMANSA / 277 Sinjai</title>
  
  <!-- SEO & Meta Tags -->
  <meta name="description" content="Portal Resmi Ikatan Alumni SMA Negeri 1 Sinjai (IKA SMANSA / 277). Wadah silaturahmi, informasi, dan kolaborasi seluruh alumni lintas angkatan.">
  <meta name="keywords" content="IKA SMANSA, 277 Sinjai, Alumni SMAN 1 Sinjai, Portal Alumni, Sinjai, Ikatan Alumni">
  <meta name="author" content="IKA SMANSA / 277 Sinjai">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= current_url() ?>">
  <meta property="og:title" content="<?= esc($title ?? 'Portal Alumni') ?> - IKA SMANSA / 277 Sinjai">
  <meta property="og:description" content="Portal Resmi Ikatan Alumni SMA Negeri 1 Sinjai (IKA SMANSA / 277). Wadah silaturahmi, informasi, dan kolaborasi seluruh alumni lintas angkatan.">
  <meta property="og:image" content="<?= base_url('images/meta.png') ?>">

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="<?= current_url() ?>">
  <meta property="twitter:title" content="<?= esc($title ?? 'Portal Alumni') ?> - IKA SMANSA / 277 Sinjai">
  <meta property="twitter:description" content="Portal Resmi Ikatan Alumni SMA Negeri 1 Sinjai (IKA SMANSA / 277). Wadah silaturahmi, informasi, dan kolaborasi seluruh alumni lintas angkatan.">
  <meta property="twitter:image" content="<?= base_url('images/meta.png') ?>">

  <link rel="shortcut icon" href="<?= base_url("images/ika.png"); ?>" type="image/png">

  <!-- Fonts & Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">

  <!-- Core Scripts -->
  <script src="<?= base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
  <!-- ApexCharts CDN -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sidebar Mobile Toggle
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileSidebar = document.getElementById('mobile-sidebar');
      const mobileSidebarBackdrop = document.getElementById('mobile-sidebar-backdrop');
      const mobileSidebarPanel = document.getElementById('mobile-sidebar-panel');

      if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', () => {
          mobileSidebar.classList.remove('hidden');
          setTimeout(() => {
            mobileSidebarBackdrop.classList.replace('opacity-0', 'opacity-100');
            mobileSidebarPanel.classList.replace('-translate-x-full', 'translate-x-0');
          }, 10);
        });
      }

      function closeMobileMenu() {
        if (!mobileSidebarBackdrop) return;
        mobileSidebarBackdrop.classList.replace('opacity-100', 'opacity-0');
        mobileSidebarPanel.classList.replace('translate-x-0', '-translate-x-full');
        setTimeout(() => mobileSidebar.classList.add('hidden'), 300);
      }

      if (mobileSidebarBackdrop) mobileSidebarBackdrop.addEventListener('click', closeMobileMenu);
      document.querySelectorAll('[data-close-sidebar]').forEach(el => el.addEventListener('click', closeMobileMenu));

      // Dropdown Toggles
      document.querySelectorAll('[data-toggle-dropdown]').forEach(button => {
        const menuId = button.getAttribute('data-toggle-dropdown');
        const menu = document.getElementById(menuId);
        button.addEventListener('click', (e) => {
          e.stopPropagation();
          menu.classList.toggle('hidden');
        });
      });

      // Modal Toggles
      document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', (e) => {
          const target = document.querySelector(button.getAttribute('data-bs-target'));
          if (target) target.classList.remove('hidden');
        });
      });

      document.querySelectorAll('[data-close-modal]').forEach(button => {
        button.addEventListener('click', () => {
          const modal = button.closest('.modal') || document.getElementById(button.getAttribute('data-close-modal'));
          if (modal) modal.classList.add('hidden');
        });
      });

      window.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
      });
    });

    function copyLink(link) {
      navigator.clipboard.writeText(link).then(() => alert('Link disalin!'));
    }
  </script>
</head>

<body class="h-full">
  <div class="min-h-full">
    <?php if (!$is_auth_page): ?>
      <!-- Mobile Sidebar -->
      <div id="mobile-sidebar" class="relative z-50 lg:hidden hidden" role="dialog" aria-modal="true">
        <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-blue-900/80 transition-opacity ease-linear duration-300 opacity-0"></div>
        <div class="fixed inset-0 flex">
          <div id="mobile-sidebar-panel" class="relative mr-16 flex w-full max-w-xs flex-1 transform transition ease-in-out duration-300 -translate-x-full bg-blue-900">
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
              <button type="button" data-close-sidebar class="-m-2.5 p-2.5 text-white">
                <i class="fa fa-times text-xl"></i>
              </button>
            </div>
            <!-- Sidebar content -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4 ring-1 ring-white/10">
              <a href="<?= base_url(); ?>" class="flex h-16 shrink-0 items-center gap-x-3 mt-4">
                <img src="<?= base_url("images/ika.png") ?>" class="h-8 w-auto" alt="Logo">
                <span class="text-white font-black tracking-tight text-lg uppercase italic">IKA SMANSA / 277 Sinjai</span>
              </a>
              <nav class="flex flex-1 flex-col mt-4">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                  <li>
                    <ul role="list" class="-mx-2 space-y-1">
                      <li><a href="<?= base_url(); ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-bold <?= url_is('/') || url_is('dashboard*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:text-white hover:bg-blue-800' ?>"><i class="fa fa-home w-6 text-center text-lg text-yellow-400"></i> Dashboard</a></li>
                      <?php if ($is_logged_in && !empty($session->get('referral'))): ?>
                        <li><a href="<?= site_url('alumni'); ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-bold <?= url_is('alumni*') && !url_is('admin*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:text-white hover:bg-blue-800' ?>"><i class="fa fa-users w-6 text-center text-lg text-red-500"></i> Alumni</a></li>
                      <?php endif; ?>
                      <?php if ($is_admin): ?>
                        <li><a href="<?= site_url('admin/counter'); ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-bold <?= url_is('admin/counter*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:text-white hover:bg-blue-800' ?>"><i class="fa fa-chart-bar w-6 text-center text-lg text-indigo-500"></i> Traffic</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                  <?php if ($is_logged_in): ?>
                    <li class="mt-auto">
                      <button data-bs-toggle="modal" data-bs-target="#referralModal" class="w-full bg-yellow-400 text-blue-900 flex items-center gap-x-3 rounded-xl p-3 text-xs font-black uppercase tracking-widest justify-center">
                        <i class="fa fa-link"></i> Undang
                      </button>
                    </li>
                  <?php endif; ?>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!$is_auth_page): ?>
      <!-- Static sidebar for desktop -->
      <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-blue-900 px-6 pb-4 shadow-2xl">
          <a href="<?= base_url(); ?>" class="flex h-16 shrink-0 items-center gap-x-3 mt-8 border-b border-white/5 pb-8">
            <img src="<?= base_url("images/ika.png") ?>" class="h-14 w-auto drop-shadow-xl" alt="Logo">
            <span class="text-white text-xl font-black tracking-tighter uppercase italic leading-none">Portal<br><span class="text-yellow-400">Alumni</span></span>
          </a>
          <nav class="flex flex-1 flex-col mt-10">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
              <li>
                <ul role="list" class="-mx-2 space-y-2">
                  <li><a href="<?= base_url(); ?>" class="group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-black transition-all border-l-4 <?= url_is('/') || url_is('dashboard*') ? 'bg-blue-800 text-white border-yellow-400 shadow-lg' : 'text-blue-100 hover:bg-blue-800 hover:text-white border-transparent' ?>"><i class="fa fa-chart-line w-6 text-center text-lg text-yellow-400"></i> Dashboard</a></li>
                  <?php if ($is_logged_in && !empty($session->get('referral'))): ?>
                    <li><a href="<?= site_url('alumni'); ?>" class="group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-black transition-all border-l-4 <?= url_is('alumni*') && !url_is('admin*') ? 'bg-blue-800 text-white border-red-500 shadow-lg' : 'text-blue-100 hover:bg-blue-800 hover:text-white border-transparent' ?>"><i class="fa fa-users w-6 text-center text-lg text-red-500"></i> Alumni</a></li>
                  <?php endif; ?>
                  <?php if ($is_admin): ?>
                    <li><a href="<?= site_url('admin/counter'); ?>" class="group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-black transition-all border-l-4 <?= url_is('admin/counter*') ? 'bg-blue-800 text-white border-indigo-500 shadow-lg' : 'text-blue-100 hover:bg-blue-800 hover:text-white border-transparent' ?>"><i class="fa fa-chart-bar w-6 text-center text-lg text-indigo-500"></i> Traffic</a></li>
                  <?php endif; ?>
                </ul>
              </li>
              <?php if ($is_logged_in): ?>
                <li class="mt-auto mb-6">
                  <button data-bs-toggle="modal" data-bs-target="#referralModal" class="w-full bg-yellow-400 hover:bg-yellow-300 text-blue-900 group flex items-center gap-x-3 rounded-2xl p-4 text-[10px] font-black uppercase tracking-[0.2em] justify-center transition-all shadow-xl shadow-yellow-400/20 border-b-4 border-yellow-600 active:border-b-0 active:translate-y-1">
                    <i class="fa fa-link animate-bounce"></i> Undang
                  </button>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
    <?php endif; ?>

    <!-- Main Content Wrapper -->
    <div class="<?= $is_auth_page ? '' : 'lg:pl-64' ?>">
      <?php if (!$is_auth_page): ?>
        <!-- Topbar -->
        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white/80 backdrop-blur-md px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
          <button id="mobile-menu-button" type="button" class="-m-2.5 p-2.5 text-blue-900 lg:hidden">
            <i class="fa fa-bars text-xl"></i>
          </button>

          <div class="h-6 w-px bg-slate-200 lg:hidden" aria-hidden="true"></div>

          <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <div class="relative flex flex-1 items-center">
              <?php if ($is_admin): ?>
                <form class="w-full max-w-lg" action="<?= site_url('alumni/search'); ?>" method="get">
                  <label for="search-field" class="sr-only">Cari</label>
                  <div class="relative w-full">
                    <i class="fa fa-search absolute inset-y-0 left-0 h-full w-5 text-slate-400 flex items-center pointer-events-none"></i>
                    <input id="search-field" class="block h-full w-full border-0 py-0 pl-8 pr-0 text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none sm:text-sm font-bold" placeholder="Cari..." type="search" name="q" value="<?= esc(request()->getGet('q')) ?>">
                  </div>
                </form>
              <?php endif; ?>
            </div>

            <div class="flex items-center gap-x-4 lg:gap-x-6">
              <!-- Clock Info -->
              <div class="hidden md:flex flex-col text-right mr-4 border-r pr-4 border-slate-200">
                <?php
                $nama_hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                ?>
                <span class="text-[10px] font-black text-blue-900 uppercase tracking-tighter"><?= $nama_hari[date('l')] ?>, <?= date('d/m/Y') ?></span>
                <span class="text-xs font-bold text-red-600 tabular-nums leading-none"><?= date('H:i:s') ?> <span class="text-[9px] font-black opacity-50">WITA</span></span>
              </div>

              <!-- Profile dropdown -->
              <?php if ($is_logged_in): ?>
                <div class="relative">
                  <button type="button" data-toggle-dropdown="user-dropdown" class="-m-1.5 flex items-center p-1.5 group" id="user-menu-button">
                    <div class="h-9 w-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-900 font-black border-2 border-blue-200 shadow-sm group-hover:scale-105 transition-transform overflow-hidden">
                      <?php
                      $profil_foto = $session->get('foto_profil');
                      if ($profil_foto && file_exists(FCPATH . 'uploads/foto_alumni/' . $profil_foto)):
                      ?>
                        <img src="<?= base_url('uploads/foto_alumni/' . $profil_foto) ?>" class="h-full w-full object-cover">
                      <?php else: ?>
                        <?= esc(substr($session->get('nama_lengkap'), 0, 1)) ?>
                      <?php endif; ?>
                    </div>
                    <span class="hidden lg:flex lg:items-center">
                      <span class="ml-4 text-sm font-black leading-6 text-slate-900 uppercase tracking-tight" aria-true="true"><?= esc($session->get('nama_lengkap')); ?></span>
                      <i class="fa fa-chevron-down ml-2 text-slate-400 group-hover:text-blue-900 text-[10px] transition-colors"></i>
                    </span>
                  </button>
                  <div id="user-dropdown" class="dropdown-menu absolute right-0 z-10 mt-2.5 w-64 origin-top-right rounded-2xl bg-white py-3 shadow-2xl ring-1 ring-slate-900/5 focus:outline-none hidden border border-slate-100">
                    <div class="px-4 py-3 border-b border-slate-50 mb-2 bg-slate-50/50">
                      <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Profil</p>
                      <p class="text-xs font-black text-blue-900 uppercase tracking-tight"><?= esc($session->get('nama_lengkap')); ?></p>
                      <p class="text-[10px] font-bold text-indigo-600 mt-1 uppercase italic">Angkatan <?= esc($session->get('angkatan')) ?></p>
                    </div>
                    <a href="<?= site_url('alumni/detail/' . $session->get('id_alumni')); ?>" class="flex items-center px-4 py-2.5 text-sm font-black text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition-colors uppercase tracking-widest text-[10px]"><i class="fa fa-user-circle mr-3 text-blue-900 text-lg"></i> Detail</a>
                    <div class="my-2 border-t border-slate-100"></div>
                    <a href="<?= site_url('auth/logout'); ?>" class="flex items-center px-4 py-2.5 text-sm font-black text-red-600 hover:bg-red-50 transition-colors uppercase tracking-widest text-[10px]"><i class="fa fa-sign-out-alt mr-3 text-red-500 text-lg"></i> Keluar</a>
                  </div>
                </div>
              <?php else: ?>
                <a href="<?= site_url('auth/login'); ?>" class="text-xs font-black uppercase tracking-widest text-blue-900 hover:text-red-600 transition-colors ring-1 ring-blue-900 px-4 py-2 rounded-xl shadow-sm">Login &rarr;</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <main class="<?= $is_auth_page ? 'py-0' : 'py-10' ?>">
        <div class="<?= $is_auth_page ? '' : 'px-4 sm:px-6 lg:px-8 max-w-[1600px] mx-auto' ?>">
          <!-- Alert Notifications -->
          <?php if ($session->getFlashdata('success')): ?>
            <div class="mb-10 rounded-2xl bg-white p-6 border-l-[6px] border-emerald-500 shadow-xl shadow-emerald-500/5 flex items-center gap-5">
              <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0 shadow-inner">
                <i class="fa fa-check-double text-xl"></i>
              </div>
              <div>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-0.5">Berhasil</p>
                <p class="text-sm font-bold text-slate-800"><?= esc($session->getFlashdata('success')) ?></p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($session->getFlashdata('error')): ?>
            <div class="mb-10 rounded-2xl bg-white p-6 border-l-[6px] border-red-600 shadow-xl shadow-red-600/5 flex items-center gap-5">
              <div class="h-12 w-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 flex-shrink-0 shadow-inner">
                <i class="fa fa-triangle-exclamation text-xl"></i>
              </div>
              <div>
                <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-0.5">Gagal</p>
                <p class="text-sm font-bold text-slate-800"><?= esc($session->getFlashdata('error')) ?></p>
              </div>
            </div>
          <?php endif; ?>

          <!-- Referral Modal -->
          <?php if ($is_logged_in): ?>
            <div id="referralModal" class="modal fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
              <div class="flex min-h-full items-center justify-center p-4">
                <div class="fixed inset-0 bg-blue-900/80 backdrop-blur-sm transition-opacity" data-close-modal></div>
                <div class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xs border border-slate-100">
                  <div class="p-8">
                    <div class="text-center mb-6">
                      <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-yellow-400 text-blue-900 shadow-xl shadow-yellow-400/20 mb-4 italic font-black text-xl">
                        <i class="fab fa-whatsapp"></i>
                      </div>
                      <h3 class="text-xl font-black text-slate-900 uppercase italic leading-none">Undang Alumni</h3>
                      <p class="text-[9px] text-slate-400 font-bold mt-2 tracking-[0.2em] uppercase text-center">Bagikan link referral Anda</p>
                    </div>

                    <?php
                    $referralLink = base_url('alumni/create?ut=' . $session->get('referral'));
                    $whatsappLink = "https://wa.me/?text=" . urlencode("Halo Alumni SMAN 1/277 Sinjai! Silakan daftar melalui link ini: " . $referralLink);
                    ?>

                    <div class="space-y-6">
                      <div class="space-y-2">
                        <label class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Link Referral</label>
                        <div class="flex gap-2 p-1 bg-slate-50 rounded-xl ring-1 ring-slate-200">
                          <input type="text" readonly value="<?= esc($referralLink) ?>" class="block w-full border-0 bg-transparent py-2 px-3 text-slate-900 text-[9px] font-black font-mono focus:ring-0">
                          <button onclick="copyLink('<?= esc($referralLink) ?>')" class="rounded-lg bg-blue-900 px-3 py-1.5 text-white shadow-lg hover:bg-blue-800 active:scale-95 transition-all text-xs">
                            <i class="fa fa-copy"></i>
                          </button>
                        </div>
                      </div>

                      <a href="<?= esc($whatsappLink) ?>" target="_blank" rel="noopener noreferrer" class="flex w-full items-center justify-center gap-x-3 rounded-xl bg-emerald-600 px-4 py-3 text-[9px] font-black text-white shadow-xl shadow-emerald-600/20 hover:bg-emerald-500 transition-all uppercase tracking-[0.2em] border-b-4 border-emerald-800 active:border-b-0 active:translate-y-1">
                        <i class="fab fa-whatsapp text-lg"></i> Undang via WhatsApp
                      </a>

                      <div class="pt-6 border-t border-slate-100 flex flex-col items-center">
                        <span class="mb-4 text-[8px] font-black text-slate-400 uppercase tracking-[0.3em]">Atau Pindai QR</span>
                        <a href="<?= esc($referralLink) ?>" target="_blank" rel="noopener noreferrer">
                          <img src="<?= base_url('qr_code?url=' . urlencode($referralLink)) ?>" class="h-32 w-32 rounded-2xl border-2 border-slate-50 p-2 shadow-inner bg-white" alt="QR">
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="bg-slate-50 px-8 py-5 border-t border-slate-100 flex justify-center">
                    <button type="button" data-close-modal class="text-[8px] font-black text-slate-400 hover:text-red-600 transition-colors uppercase tracking-[0.4em]">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <?= $content ?>
        </div>
      </main>

      <?php if (!$is_auth_page): ?>
        <footer class="border-t border-slate-200 bg-white py-8 mt-auto">
          <div class="px-4 sm:px-6 lg:px-8 max-w-[1600px] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-x-4 text-blue-900">
              <img src="<?= base_url("images/ika.png") ?>" class="h-8 w-auto grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-pointer" alt="Logo">
              <p class="text-sm font-bold text-slate-400 tracking-tight leading-none">&copy; 2025 IKA SMANSA / 277 Sinjai. <span class="hidden sm:inline">All rights reserved.</span></p>
            </div>
            <div class="flex gap-x-8">
              <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">SINJAI, INDONESIA</span>
            </div>
          </div>
        </footer>
      <?php endif; ?>
    </div>
  </div>

  <script>
    (function() {
      'use strict';
      const forms = document.querySelectorAll('.needs-validation');
      Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
              firstInvalid.focus();
              firstInvalid.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });
            }
          }
          form.classList.add('was-validated');
        }, false);
      });
    })();
  </script>
</body>

</html>