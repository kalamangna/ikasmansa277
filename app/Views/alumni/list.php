<?php
$session = session();
$userRole = $session->get('role');
$userId = $session->get('id_alumni');
?>
<div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-y-6">
  <div>
    <h1 class="text-3xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">Alumni</h1>
    <p class="text-sm text-slate-400 font-bold mt-2 uppercase tracking-widest leading-none">Database Alumni</p>
  </div>
  <div class="flex items-center gap-x-3">
    <?php if ($userRole === 'admin' || $userRole === 'admin_angkatan'): ?>
      <a href="<?= site_url('alumni/create') ?>" class="inline-flex items-center gap-x-3 rounded-2xl bg-blue-900 px-6 py-3.5 text-xs font-black text-white shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all uppercase tracking-widest border-b-4 border-blue-950 active:border-b-0 active:translate-y-1">
        <i class="fas fa-plus text-yellow-400"></i>
        Tambah Alumni
      </a>
    <?php endif; ?>
  </div>
</div>

<div class="bg-white shadow-xl shadow-slate-200/50 border border-slate-200 rounded-[2rem] overflow-hidden mb-12">
  <!-- Filters & Search -->
  <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
    <form method="get" action="<?= site_url('alumni') ?>" class="flex flex-col sm:flex-row sm:items-center gap-4 w-full lg:w-auto">
      <div class="flex items-center gap-x-4">
        <label for="angkatan" class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Angkatan</label>
        <div class="relative group">
          <select name="angkatan" id="angkatan" onchange="this.form.submit()" class="appearance-none rounded-xl border-slate-200 py-2.5 pl-5 pr-12 text-sm font-black text-blue-900 focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 bg-white shadow-sm transition-all cursor-pointer">
            <option value="" <?= empty($selected_angkatan) ? 'selected' : ''; ?>>Semua Angkatan</option>
            <?php foreach ($angkatan_list as $angk): ?>
              <option value="<?= esc($angk['angkatan']); ?>" <?= ($selected_angkatan == $angk['angkatan']) ? 'selected' : ''; ?>>
                Angkatan <?= esc($angk['angkatan']); ?> (<?= (int)$angk['jumlah_laki_laki'] + (int)$angk['jumlah_perempuan'] ?> alumni)
              </option>
            <?php endforeach; ?>
          </select>
          <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-hover:text-blue-900 transition-colors">
            <i class="fa fa-chevron-down text-[10px]"></i>
          </div>
        </div>
      </div>
      <div class="relative flex-1 group">
        <label for="search-field" class="sr-only">Cari</label>
        <div class="relative w-full">
          <i class="fa fa-search absolute inset-y-0 left-0 h-full w-5 text-slate-400 flex items-center pl-4 pointer-events-none"></i>
          <input id="search-field" class="block h-full w-full rounded-xl border-slate-200 py-2.5 pl-10 pr-4 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-bold placeholder:text-slate-400 transition-all" placeholder="Cari alumni..." type="search" name="q" value="<?= esc($search_query); ?>">
          <?php if (!empty($search_query) || !empty($selected_angkatan)): ?>
            <a href="<?= site_url('alumni') ?>" class="absolute inset-y-0 right-0 h-full w-10 text-slate-400 flex items-center justify-center hover:text-red-600 transition-colors">
              <i class="fa fa-times text-xs"></i>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>

  <!-- Summary Count -->
  <div class="px-8 py-4 bg-white flex items-center justify-between text-sm font-bold text-slate-500">
    <span>
      Menampilkan <?= (int)($current_page - 1) * $per_page + 1 ?> &mdash; <?= min((int)$current_page * $per_page, $total_alumni) ?> dari <?= (int)$total_alumni ?> alumni
    </span>
    <?php if ($session->getFlashdata('success')): ?>
      <span class="text-emerald-600 font-bold"><?= esc($session->getFlashdata('success')) ?></span>
    <?php elseif ($session->getFlashdata('error')): ?>
      <span class="text-red-600 font-bold"><?= esc($session->getFlashdata('error')) ?></span>
    <?php endif; ?>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-200">
      <thead class="bg-slate-50/80">
        <tr>
          <th scope="col" class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest italic">No.</th>
          <th scope="col" class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Profil</th>
          <th scope="col" class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Jurusan</th>
          <th scope="col" class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Domisili</th>
          <th scope="col" class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Ref</th>
          <?php if ($userRole === 'admin'): ?>
            <th scope="col" class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-50 bg-white">
        <?php if (!empty($alumni_list)): ?>
          <?php $no = ($current_page - 1) * $per_page + 1; foreach ($alumni_list as $alumni): ?>
            <tr class="hover:bg-blue-50/20 transition-all group">
              <td class="px-8 py-6 whitespace-nowrap text-xs font-black text-slate-300 italic group-hover:text-blue-900 transition-colors"><?= $no++; ?></td>
              <td class="px-8 py-6 whitespace-nowrap">
                <div class="flex items-center gap-x-4">
                  <div class="h-12 w-12 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-blue-900 group-hover:text-yellow-400 transition-all shadow-inner italic font-black uppercase">
                    <?php if ($alumni->foto_profil && file_exists(FCPATH . 'uploads/foto_alumni/' . $alumni->foto_profil)): ?>
                      <img src="<?= base_url('uploads/foto_alumni/' . $alumni->foto_profil) ?>" class="h-full w-full object-cover rounded-2xl">
                    <?php else: ?>
                      <?= esc(substr($alumni->nama_lengkap, 0, 1)) ?>
                    <?php endif; ?>
                  </div>
                  <div>
                    <div class="text-sm font-black text-slate-800 group-hover:text-blue-900 transition-colors uppercase leading-none mb-1.5"><?= esc($alumni->nama_lengkap); ?></div>
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider italic opacity-60">"<?= esc($alumni->nama_panggilan ?: '-'); ?>"</div>
                  </div>
                </div>
              </td>
              <td class="px-8 py-6 whitespace-nowrap">
                <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1 text-[9px] font-black text-slate-600 uppercase tracking-widest ring-1 ring-inset ring-slate-200 group-hover:bg-blue-100 group-hover:text-blue-900 transition-all italic"><?= esc($alumni->jurusan); ?></span>
              </td>
              <td class="px-8 py-6 whitespace-nowrap">
                <div class="flex flex-col">
                  <span class="text-xs font-black text-slate-700 uppercase leading-none mb-1"><?= esc($alumni->kabupaten); ?></span>
                  <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"><?= esc($alumni->provinsi); ?></span>
                </div>
              </td>
              <td class="px-8 py-6 whitespace-nowrap text-center">
                <div class="inline-flex items-center justify-center h-8 w-8 rounded-xl bg-blue-50 text-blue-900 text-[10px] font-black ring-1 ring-blue-100 group-hover:bg-blue-900 group-hover:text-white transition-all">
                  <?= (int)$alumni->ref_jumlah; ?>
                </div>
              </td>
              <?php if ($userRole === 'admin'): ?>
                <td class="px-8 py-6 whitespace-nowrap text-right">
                  <div class="flex justify-end items-center gap-x-2">
                    <a href="<?= site_url('alumni/detail/' . $alumni->id_alumni) ?>" class="h-9 w-9 rounded-xl bg-blue-50 text-blue-900 flex items-center justify-center hover:bg-blue-900 hover:text-white transition-all shadow-sm border border-blue-100" title="Detail">
                      <i class="fas fa-id-card text-sm"></i>
                    </a>
                    <?php if ($alumni->id_alumni != $userId && (int)$alumni->ref_jumlah === 0): ?>
                      <a href="<?= site_url('alumni/delete/' . $alumni->id_alumni) ?>" onclick="return confirm('Hapus data?')" class="h-9 w-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100" title="Hapus">
                        <i class="fas fa-trash-alt text-sm"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="<?= $userRole === 'admin' ? '6' : '5' ?>" class="px-8 py-20 text-center">
              <div class="flex flex-col items-center gap-y-4">
                <div class="h-20 w-20 rounded-[2rem] bg-slate-50 flex items-center justify-center border-4 border-dashed border-slate-200 text-slate-200">
                  <i class="fa fa-inbox text-3xl"></i>
                </div>
                <div class="max-w-xs mx-auto">
                  <p class="text-sm font-black text-slate-400 uppercase tracking-widest italic">Kosong</p>
                  <p class="text-[9px] text-slate-300 font-bold mt-2 uppercase tracking-widest">Belum ada data ditemukan.</p>
                </div>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination Links -->
  <?php if (isset($pager)): ?>
    <div class="px-8 py-8 border-t border-slate-100 bg-slate-50/30">
        <?= $pager->links('default', 'gemini_pager') ?>
    </div>
  <?php endif; ?>
</div>

<script>
  // Simple JavaScript for form submission on select change for filter
  const angkatanSelect = document.getElementById('angkatan');
  if (angkatanSelect) {
    angkatanSelect.addEventListener('change', function() {
      this.form.submit();
    });
  }
</script>