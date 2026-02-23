<?php
$session = session();
$is_admin = $session->get('role') == 'admin';
$userId = $session->get('id_alumni');
?>

<div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-y-6">
  <div>
    <h1 class="text-3xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">Hasil Cari</h1>
    <p class="text-sm text-slate-400 font-bold mt-2 uppercase tracking-widest leading-none">Pencarian: <span class="text-blue-900 italic">"<?= esc($keyword); ?>"</span></p>
  </div>
  <div class="flex items-center gap-x-3">
    <a href="<?= site_url('alumni'); ?>" class="inline-flex items-center gap-x-3 rounded-2xl bg-white px-6 py-3.5 text-xs font-black text-slate-500 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all group leading-none uppercase tracking-widest">
      <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
      Kembali
    </a>
  </div>
</div>

<div class="bg-white shadow-xl shadow-slate-200/50 border border-slate-200 rounded-[2rem] overflow-hidden mb-12">
  <!-- Status -->
  <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
    <div class="flex items-center gap-x-3">
      <div class="h-8 w-8 rounded-xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-lg italic font-black text-xs">Q</div>
      <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ditemukan: <span class="text-blue-900"><?= number_format((int)$total_results, 0, ',', '.'); ?> Alumni</span></p>
    </div>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-200">
      <thead class="bg-slate-50/80">
        <tr>
          <th scope="col" class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest italic">No.</th>
          <th scope="col" class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Profil</th>
          <th scope="col" class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Angkatan</th>
          <th scope="col" class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Domisili</th>
          <th scope="col" class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Ref</th>
          <?php if ($is_admin): ?>
            <th scope="col" class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-50 bg-white">
        <?php if (!empty($results)): ?>
          <?php $no = (int)$current_offset + 1; foreach ($results as $alumni): ?>
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
              <td class="px-8 py-6 whitespace-nowrap text-center">
                <span class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1 text-[9px] font-black text-blue-900 ring-1 ring-inset ring-blue-100 uppercase tracking-widest"><?= esc($alumni->angkatan); ?></span>
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
              <?php if ($is_admin): ?>
                <td class="px-8 py-6 whitespace-nowrap text-right">
                  <div class="flex justify-end items-center gap-x-2">
                    <a href="<?= site_url('alumni/detail/' . $alumni->id_alumni) ?>" class="h-9 w-9 rounded-xl bg-blue-50 text-blue-900 flex items-center justify-center hover:bg-blue-900 hover:text-white transition-all shadow-sm border border-blue-100" title="Detail">
                      <i class="fas fa-id-card text-sm"></i>
                    </a>
                    <?php if (isset($alumni->id_alumni) && $alumni->id_alumni != $userId && (int)$alumni->ref_jumlah === 0): ?>
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
            <td colspan="<?= $is_admin ? '6' : '5' ?>" class="px-8 py-20 text-center">
              <div class="flex flex-col items-center gap-y-4">
                <div class="h-20 w-20 rounded-[2rem] bg-slate-50 flex items-center justify-center border-4 border-dashed border-slate-200 text-slate-200">
                  <i class="fa fa-magnifying-glass text-3xl"></i>
                </div>
                <div class="max-w-xs mx-auto">
                  <p class="text-sm font-black text-slate-400 uppercase tracking-widest italic">Kosong</p>
                  <p class="text-[9px] text-slate-300 font-bold mt-2 uppercase tracking-widest">Alumni tidak ditemukan.</p>
                </div>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php if (isset($pager)): ?>
  <div class="px-8 py-8">
    <?= $pager->links('default', 'gemini_pager') ?>
  </div>
<?php endif; ?>