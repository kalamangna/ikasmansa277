<?php
$session = session();
$userRole = $session->get('role');
$userAngkatan = $session->get('angkatan');
$alumniAngkatan = $alumni->angkatan;
$urlPendataan = site_url('alumni/create?ut=' . $session->get('referral'));
?>

<div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-y-6">
  <div>
    <h1 class="text-3xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">Profil</h1>
    <p class="text-sm text-slate-400 font-bold mt-2 uppercase tracking-widest leading-none">Data Terverifikasi</p>
  </div>
  <div class="flex items-center gap-x-3">
    <?php if ($show_edit): ?>
      <a href="<?= site_url('alumni/edit/' . $alumni->id_alumni) ?>" class="inline-flex items-center gap-x-3 rounded-2xl bg-blue-900 px-6 py-3.5 text-xs font-black text-white shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all uppercase tracking-widest border-b-4 border-blue-950 active:border-b-0 active:translate-y-1">
        <i class="fas fa-edit text-yellow-400"></i>
        Edit
      </a>
    <?php endif; ?>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start mb-16">
  <!-- Profile Sidebar -->
  <div class="lg:col-span-4 space-y-8">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden text-center p-10 relative">
      <div class="absolute top-0 left-0 w-full h-24 bg-blue-900"></div>
      <div class="relative z-10">
        <div class="relative inline-block group">
          <div class="h-40 w-40 rounded-[2.5rem] overflow-hidden ring-8 ring-white shadow-2xl mx-auto bg-slate-100 border-4 border-slate-50">
            <?php if (!empty($alumni->foto_profil) && file_exists(FCPATH . 'uploads/foto_alumni/' . $alumni->foto_profil)): ?>
              <img src="<?= base_url('uploads/foto_alumni/' . $alumni->foto_profil) ?>" class="h-full w-full object-cover" alt="Foto">
            <?php else: ?>
              <div class="h-full w-full flex items-center justify-center text-slate-300">
                <i class="fas fa-user-graduate text-6xl"></i>
              </div>
            <?php endif; ?>
          </div>
          <?php if ($show_edit): ?>
            <button data-bs-toggle="modal" data-bs-target="#uploadPhotoModal" class="absolute -bottom-2 -right-2 h-12 w-12 bg-yellow-400 text-blue-900 rounded-2xl flex items-center justify-center border-4 border-white shadow-xl hover:scale-110 transition-transform hover:bg-yellow-300">
              <i class="fas fa-camera text-sm"></i>
            </button>
          <?php endif; ?>
        </div>
        
        <div class="mt-8">
          <h2 class="text-2xl font-black text-slate-900 tracking-tight leading-tight uppercase italic"><?= esc($alumni->nama_lengkap); ?></h2>
          <div class="mt-4 flex flex-col items-center gap-y-3">
            <span class="inline-flex items-center rounded-xl bg-blue-900 px-4 py-1.5 text-[10px] font-black text-yellow-400 uppercase tracking-[0.2em] shadow-lg">Angkatan <?= esc($alumni->angkatan); ?></span>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest italic opacity-60">"<?= esc($alumni->nama_panggilan ?: '-'); ?>"</p>
          </div>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-6 border-t border-slate-100 pt-10">
          <div class="text-center">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Peringkat Angkatan</p>
            <p class="text-2xl font-black text-blue-900 italic tabular-nums">#<?= (int)$urutan_angkatan; ?></p>
          </div>
          <div class="text-center border-l border-slate-100">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Peringkat Global</p>
            <p class="text-2xl font-black text-blue-900 italic tabular-nums">#<?= (int)$urutan_alumni; ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Referral Stats -->
    <div class="bg-blue-900 rounded-[2rem] shadow-2xl border border-blue-950 overflow-hidden relative">
      <div class="absolute -right-10 -top-10 h-40 w-40 bg-white/5 rounded-full blur-3xl"></div>
      <div class="p-8 relative z-10">
        <div class="flex items-center justify-between mb-8">
          <h3 class="text-xs font-black text-yellow-400 uppercase tracking-[0.2em] leading-none italic">Referral</h3>
          <i class="fa fa-share-nodes text-blue-300 opacity-50"></i>
        </div>
        
        <div class="space-y-6">
          <div class="flex items-center justify-between bg-white/5 p-4 rounded-2xl border border-white/5">
            <span class="text-xs font-bold text-blue-100 uppercase tracking-widest">Diundang</span>
            <span class="text-2xl font-black text-white tabular-nums italic"><?= number_format(count($get_alumni_by_referred_by), 0, ',', '.') ?></span>
          </div>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($get_alumni_by_referred_by as $reffered): ?>
              <a href="<?= base_url('alumni/detail/' . $reffered->id_alumni) ?>" class="inline-flex items-center rounded-lg bg-white/10 px-3 py-1.5 text-[9px] font-black text-blue-100 hover:bg-yellow-400 hover:text-blue-900 transition-all uppercase tracking-widest"><?= esc($reffered->nama_lengkap) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        
        <button data-bs-toggle="modal" data-bs-target="#undangModal" class="mt-8 w-full bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-6 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-yellow-400/20 border-b-4 border-yellow-600 active:border-b-0 active:translate-y-1">
          <i class="fa fa-link mr-2 animate-pulse"></i> Undang
        </button>
      </div>
    </div>

    <?php if (!empty($alumni->referred_by)): ?>
      <?php 
        $alumniModel = model('AlumniModel');
        $ref_parent = $alumniModel->getByReferral($alumni->referred_by); 
      ?>
      <?php if ($ref_parent): ?>
        <div class="bg-white rounded-[1.5rem] p-6 border border-slate-200 shadow-sm flex items-center gap-x-5 group hover:border-blue-900 transition-colors">
          <div class="h-12 w-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-900 transition-all shadow-inner">
            <i class="fa fa-link text-blue-900 group-hover:text-yellow-400 text-lg"></i>
          </div>
          <div class="min-w-0">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none mb-1.5">Diundang Oleh</p>
            <a href="<?= base_url('alumni/detail/' . $ref_parent->id_alumni) ?>" class="text-sm font-black text-slate-800 hover:text-blue-900 transition-colors uppercase truncate block leading-none"><?= esc($ref_parent->nama_lengkap) ?></a>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <!-- Main Content -->
  <div class="lg:col-span-8 space-y-10">
    <!-- Personal -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h3 class="text-sm font-black text-blue-900 uppercase tracking-[0.2em] italic">Personal</h3>
        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-3 py-1 bg-white rounded-full border border-slate-100">Daftar: <?= date('d M Y', strtotime($alumni->created_at)) ?></span>
      </div>
      <div class="p-10 grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-10">
        <div class="space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Nama Lengkap</p>
          <p class="text-sm font-black text-slate-800 italic"><?= esc($alumni->nama_lengkap); ?></p>
        </div>
        <div class="space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Lahir</p>
          <p class="text-sm font-black text-slate-800"><?= esc($alumni->tempat_lahir . ', ' . model('AlumniModel')->formatTanggalIndo($alumni->tanggal_lahir)); ?></p>
        </div>
        <div class="space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Jenis Kelamin</p>
          <p class="text-sm font-black text-slate-800"><?= esc($alumni->jenis_kelamin); ?></p>
        </div>
        <div class="space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Jurusan</p>
          <p class="text-sm font-black text-blue-900 underline decoration-yellow-400 decoration-2 underline-offset-4 italic"><?= esc($alumni->jurusan) ?></p>
        </div>
      </div>
    </div>

    <!-- Pekerjaan -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between bg-blue-900 text-white">
        <h3 class="text-sm font-black uppercase tracking-[0.2em] italic">Pekerjaan</h3>
        <i class="fa fa-briefcase text-yellow-400"></i>
      </div>
      <div class="p-10 grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-10">
        <div class="space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Sektor</p>
          <p class="text-sm font-black text-slate-800 italic"><?= esc($alumni->nama_pekerjaan ?: 'N/A'); ?></p>
        </div>
        <div class="space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Jabatan</p>
          <p class="text-sm font-black text-blue-900"><?= esc($alumni->jabatan ?: '-'); ?></p>
        </div>
        <div class="sm:col-span-2 space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Instansi</p>
          <p class="text-sm font-black text-slate-800"><?= esc($alumni->nama_perusahaan ?: '-'); ?></p>
        </div>
        <div class="sm:col-span-2 space-y-2">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Alamat Kantor</p>
          <p class="text-xs font-bold text-slate-600 leading-relaxed opacity-80"><?= esc($alumni->alamat_kantor ?: '-'); ?></p>
        </div>
      </div>
    </div>

    <!-- Kontak -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
      <div class="px-10 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h3 class="text-sm font-black text-blue-900 uppercase tracking-[0.2em] italic">Kontak</h3>
        <i class="fa fa-address-book text-slate-300"></i>
      </div>
      <div class="p-10 space-y-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
          <div class="space-y-2">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Email</p>
            <p class="text-sm font-black text-blue-900 underline decoration-blue-100 underline-offset-4"><?= esc($alumni->email ?: '-'); ?></p>
          </div>
          <div class="space-y-2">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">WhatsApp</p>
            <p class="text-sm font-black text-emerald-600 flex items-center gap-2"><i class="fab fa-whatsapp"></i> <?= esc($alumni->no_telepon ?: '-'); ?></p>
          </div>
        </div>
        <div class="space-y-2 pt-10 border-t border-slate-100">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Domisili</p>
          <p class="text-sm font-black text-slate-800 italic"><?= esc($alumni->alamat_domisili); ?></p>
          <div class="mt-4 flex items-center gap-x-2">
            <span class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1 text-[9px] font-black text-blue-900 ring-1 ring-inset ring-blue-200 uppercase tracking-widest"><?= esc($alumni->kabupaten) ?></span>
            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1 text-[9px] font-black text-slate-600 ring-1 ring-inset ring-slate-200 uppercase tracking-widest"><?= esc($alumni->provinsi) ?></span>
          </div>
        </div>
      </div>
    </div>

    <?php if ($userRole == 'admin' || ($userRole == 'admin_angkatan' && $userAngkatan == $alumniAngkatan)): ?>
    <div class="bg-slate-900 rounded-[2rem] border border-slate-800 p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-2xl">
      <div class="flex items-center gap-x-5">
        <div class="h-14 w-14 rounded-2xl bg-blue-900/50 flex items-center justify-center text-blue-400 shadow-inner ring-1 ring-blue-400/20">
          <i class="fa fa-shield-halved text-xl"></i>
        </div>
        <div>
          <p class="text-sm font-black text-white italic leading-none">Admin</p>
          <p class="text-[10px] text-slate-500 font-bold mt-2 tracking-widest">Kontrol akses alumni</p>
        </div>
      </div>
      <button data-bs-toggle="modal" data-bs-target="#editUserModal" class="inline-flex items-center gap-x-3 rounded-xl bg-white/5 px-6 py-3 text-[10px] font-black text-white shadow-sm ring-1 ring-inset ring-white/10 hover:bg-white/10 transition-all uppercase tracking-widest hover:ring-blue-500">
        Edit Akses
      </button>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal: Undang -->
<div id="undangModal" class="modal fixed inset-0 z-50 hidden overflow-y-auto" role="dialog">
  <div class="flex min-h-full items-center justify-center p-4">
    <div class="fixed inset-0 bg-blue-900/80 backdrop-blur-md transition-opacity" data-close-modal></div>
    <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white shadow-2xl transition-all sm:w-full sm:max-w-md border border-slate-100">
      <div class="p-10">
        <div class="text-center mb-10">
          <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-yellow-400 text-blue-900 shadow-xl shadow-yellow-400/20 mb-6 italic font-black text-2xl">
            <i class="fab fa-whatsapp"></i>
          </div>
          <h3 class="text-2xl font-black text-slate-900 uppercase italic leading-none">Undang</h3>
          <p class="text-[10px] text-slate-400 font-bold mt-3 tracking-[0.2em] uppercase text-center">Undang teman alumni</p>
        </div>
        
        <?php
          $referralLink = base_url('alumni/create?ut=' . $alumni->referral);
          $whatsappLink = "https://wa.me/?text=" . urlencode("Halo Alumni SMAN 1/277 Sinjai! Silakan daftar melalui link ini: " . $referralLink);
        ?>

        <div class="space-y-8">
          <div class="space-y-3">
            <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Link Daftar</label>
            <div class="flex gap-2 p-1 bg-slate-50 rounded-2xl ring-1 ring-slate-200">
              <input type="text" readonly value="<?= esc($referralLink) ?>" class="block w-full border-0 bg-transparent py-2.5 px-4 text-slate-900 text-[10px] font-black font-mono focus:ring-0">
              <button onclick="copyLink('<?= esc($referralLink) ?>')" class="rounded-xl bg-blue-900 px-4 py-2 text-white shadow-lg hover:bg-blue-800 active:scale-95 transition-all">
                <i class="fa fa-copy"></i>
              </button>
            </div>
          </div>

          <a href="<?= esc($whatsappLink) ?>" target="_blank" class="flex w-full items-center justify-center gap-x-3 rounded-[1.5rem] bg-emerald-600 px-4 py-5 text-[10px] font-black text-white shadow-2xl shadow-emerald-600/20 hover:bg-emerald-500 transition-all uppercase tracking-[0.2em] border-b-4 border-emerald-800 active:border-b-0 active:translate-y-1">
            <i class="fab fa-whatsapp text-xl"></i> WhatsApp
          </a>

          <div class="pt-10 border-t border-slate-100 flex flex-col items-center">
            <span class="mb-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Scan QR</span>
            <img src="<?= base_url('qr_code?url=' . urlencode($referralLink)) ?>" class="h-48 w-48 rounded-3xl border-4 border-slate-50 p-3 shadow-inner bg-white" alt="QR">
          </div>
        </div>
      </div>
      <div class="bg-slate-50 px-10 py-6 border-t border-slate-100 flex justify-center">
        <button type="button" data-close-modal class="text-[9px] font-black text-slate-400 hover:text-red-600 transition-colors uppercase tracking-[0.4em]">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Akses -->
<div id="editUserModal" class="modal fixed inset-0 z-50 hidden overflow-y-auto" role="dialog">
  <div class="flex min-h-full items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity" data-close-modal></div>
    <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white shadow-2xl transition-all sm:w-full sm:max-w-lg text-left border border-slate-100">
      <form method="post" action="<?= site_url('alumni/update_user/' . $alumni->id_alumni); ?>" class="needs-validation" novalidate>
        <div class="px-10 pt-10 pb-8">
          <div class="flex items-center gap-x-4 mb-10">
            <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl italic font-black text-xl">ID</div>
            <div>
              <h3 class="text-xl font-black text-slate-900 italic leading-none uppercase">Akses</h3>
              <p class="text-[10px] text-slate-400 font-bold mt-2 tracking-widest">Edit login</p>
            </div>
          </div>
          
          <div class="space-y-8">
            <div class="space-y-2">
              <label for="email" class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Email</label>
              <input type="email" id="email" name="email" value="<?= esc($alumni->email); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all" required>
            </div>

            <div class="space-y-2">
              <label for="password" class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Password</label>
              <input type="password" id="password" name="password" placeholder="••••••••" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all">
              <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest italic mt-2 ml-1">Kosongkan jika tidak ada perubahan.</p>
            </div>

            <?php if ($userRole === 'admin'): ?>
              <div class="space-y-2">
                <label for="role" class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Role</label>
                <select id="role" name="role_id" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all">
                  <?php if ($session->get('id_alumni') == '92'): ?>
                    <option value="1" <?= (($alumni->role_id ?? 0) == '1') ? 'selected' : ''; ?>>Full Admin</option>
                  <?php endif; ?>
                  <option value="2" <?= (($alumni->role_id ?? 0) == '2') ? 'selected' : ''; ?>>Batch Admin</option>
                  <option value="5" <?= (($alumni->role_id ?? 0) == '5') ? 'selected' : ''; ?>>Alumni</option>
                </select>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="bg-slate-50 px-10 py-8 flex flex-col sm:flex-row-reverse gap-4 border-t border-slate-100">
          <input type="hidden" name="email_current" value="<?= esc($alumni->email) ?>">
          <input type="hidden" name="alumni_id" value="<?= esc($alumni->id_alumni) ?>">
          <button type="submit" class="inline-flex justify-center rounded-2xl bg-blue-900 px-10 py-4 text-[10px] font-black text-white shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all uppercase tracking-[0.2em] border-b-4 border-blue-950">Simpan</button>
          <button type="button" data-close-modal class="inline-flex justify-center rounded-2xl bg-white px-10 py-4 text-[10px] font-black text-slate-500 ring-1 ring-inset ring-slate-200 hover:bg-slate-100 transition-all uppercase tracking-[0.2em]">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Foto -->
<div id="uploadPhotoModal" class="modal fixed inset-0 z-50 hidden overflow-y-auto" role="dialog">
  <div class="flex min-h-full items-center justify-center p-4">
    <div class="fixed inset-0 bg-blue-900/90 backdrop-blur-sm transition-opacity" data-close-modal></div>
    <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white shadow-2xl transition-all sm:w-full sm:max-w-md border border-slate-100">
      <form action="<?= site_url('alumni/upload_photo/' . $alumni->id_alumni) ?>" method="post" enctype="multipart/form-data">
        <div class="p-12">
          <div class="text-center mb-10">
            <div class="mx-auto h-16 w-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-900 mb-6 shadow-inner ring-1 ring-blue-100">
              <i class="fa fa-camera-retro text-2xl"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-900 uppercase italic leading-none">Foto</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-3 tracking-widest leading-relaxed">Edit foto profil</p>
          </div>
          
          <div class="group relative flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-slate-200 px-6 py-14 hover:border-blue-900 hover:bg-slate-50/50 transition-all cursor-pointer overflow-hidden">
            <input id="foto_profil" name="foto_profil" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" required>
            <div class="text-center">
              <i class="fas fa-cloud-upload-alt text-5xl text-slate-200 mb-6 group-hover:text-blue-900 transition-all transform group-hover:-translate-y-2"></i>
              <div class="flex text-sm leading-6 text-slate-600 justify-center">
                <span class="relative font-black text-blue-900 group-hover:text-blue-800 tracking-widest text-[10px] uppercase">
                  Pilih File
                </span>
              </div>
              <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] mt-3 italic">JPG / PNG • MAX 10MB</p>
            </div>
          </div>
        </div>
        <div class="bg-slate-50 px-12 py-8 flex flex-col sm:flex-row-reverse gap-4 border-t border-slate-100">
          <button type="submit" class="inline-flex justify-center rounded-2xl bg-blue-900 px-10 py-4 text-[10px] font-black text-white shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all uppercase tracking-[0.2em] border-b-4 border-blue-950">Simpan</button>
          <button type="button" data-close-modal class="inline-flex justify-center rounded-2xl bg-white px-10 py-4 text-[10px] font-black text-slate-500 ring-1 ring-inset ring-slate-200 hover:bg-slate-100 transition-all uppercase tracking-[0.2em]">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function copyLink(link) {
    navigator.clipboard.writeText(link).then(function() {
      alert('Link disalin!');
    }, function() {
      alert('Gagal menyalin link.');
    });
  }
</script>