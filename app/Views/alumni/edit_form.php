<?php
$session = session();
?>
<div class="max-w-4xl mx-auto">
  <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-y-4 text-center md:text-left">
    <div>
      <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-none italic uppercase">Edit Alumni</h1>
      <p class="text-sm text-slate-500 mt-2 font-medium tracking-tight">Perbarui data alumni.</p>
    </div>
  </div>

  <div class="bg-white shadow-2xl shadow-slate-200/60 rounded-[2rem] border border-slate-200 overflow-hidden mb-12">
    <!-- Privacy Alert -->
    <div class="bg-amber-50/50 border-b border-amber-100 p-8 flex gap-x-5 items-start">
      <div class="flex-shrink-0 h-12 w-12 rounded-2xl bg-white shadow-sm flex items-center justify-center ring-1 ring-amber-200">
        <i class="fa fa-user-shield text-amber-600 text-xl"></i>
      </div>
      <div>
        <h3 class="text-sm font-bold text-amber-900 uppercase tracking-widest leading-none mb-2">Privasi</h3>
        <p class="text-xs text-amber-700/80 leading-relaxed font-medium">Data Anda bersifat konfidensial dan hanya digunakan untuk kepentingan internal organisasi.</p>
      </div>
    </div>

    <div class="p-8 lg:p-16">
      <?php if ($session->getFlashdata('success')): ?>
        <div class="mb-10 rounded-2xl bg-emerald-50 p-5 border border-emerald-100 flex items-center gap-4">
          <div class="h-10 w-10 rounded-full bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
            <i class="fa fa-check"></i>
          </div>
          <p class="text-sm font-bold text-emerald-900 leading-tight">Data disimpan!</p>
        </div>
      <?php endif; ?>
      <?php if ($session->getFlashdata('error')): ?>
        <div class="mb-10 rounded-2xl bg-rose-50 p-5 border border-rose-100 flex items-center gap-4">
          <div class="h-10 w-10 rounded-full bg-rose-500 flex items-center justify-center text-white shadow-lg shadow-rose-200">
            <i class="fa fa-times"></i>
          </div>
          <p class="text-sm font-bold text-rose-900 leading-tight"><?= esc($session->getFlashdata('error')) ?></p>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= site_url('alumni/update/' . $alumni->id_alumni); ?>" enctype="multipart/form-data" class="needs-validation space-y-12" id="editForm" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="id_alumni" value="<?= esc($alumni->id_alumni); ?>">
        
        <!-- Part 1: Profile -->
        <div class="space-y-8">
          <div class="flex items-center gap-x-4">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-900 text-white font-black shadow-xl shadow-blue-50 italic">01</span>
            <div class="h-px flex-1 bg-slate-100"></div>
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] whitespace-nowrap italic">Profil</h3>
          </div>

          <div class="grid grid-cols-1 gap-y-8">
            <div class="relative group">
              <label for="nama_lengkap" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Nama Lengkap <span class="text-rose-500">*</span></label>
              <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap', $alumni->nama_lengkap); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all" placeholder="SESUAI IJAZAH" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="relative group">
                <label for="nama_panggilan" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Panggilan</label>
                <input type="text" id="nama_panggilan" name="nama_panggilan" value="<?= old('nama_panggilan', $alumni->nama_panggilan); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all">
              </div>
              <div class="bg-slate-50/50 rounded-2xl p-4 ring-1 ring-slate-200 flex flex-col justify-center">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2 italic">Gender <span class="text-rose-500">*</span></span>
                <div class="flex gap-x-8 ml-2">
                  <label class="flex items-center gap-x-3 cursor-pointer group">
                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="h-5 w-5 border-slate-300 text-blue-900 focus:ring-blue-900 focus:ring-offset-white" <?= (old('jenis_kelamin', $alumni->jenis_kelamin) == 'Laki-laki') ? 'checked' : ''; ?> required>
                    <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900 uppercase">Laki-laki</span>
                  </label>
                  <label class="flex items-center gap-x-3 cursor-pointer group">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="h-5 w-5 border-slate-300 text-blue-900 focus:ring-blue-900 focus:ring-offset-white" <?= (old('jenis_kelamin', $alumni->jenis_kelamin) == 'Perempuan') ? 'checked' : ''; ?>>
                    <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900 uppercase">Perempuan</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="relative group">
                <label for="tempat_lahir" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Kota Lahir <span class="text-rose-500">*</span></label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?= old('tempat_lahir', $alumni->tempat_lahir); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all" required>
              </div>
              <div class="relative group">
                <label for="tanggal_lahir" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Tgl Lahir <span class="text-rose-500">*</span></label>
                <input type="text" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $alumni->tanggal_lahir); ?>" placeholder="DD-MM-YYYY" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold tabular-nums transition-all" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Part 2: Academic -->
        <div class="space-y-8">
          <div class="flex items-center gap-x-4">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-900 text-white font-black shadow-xl shadow-blue-50 italic">02</span>
            <div class="h-px flex-1 bg-slate-100"></div>
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] whitespace-nowrap italic">Akademik</h3>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="relative group">
              <label for="angkatan" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Angkatan <span class="text-rose-500">*</span></label>
              <select id="angkatan" name="angkatan" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all" required>
                <option value="" class="text-slate-400">Pilih Tahun</option>
                <?php for ($tahun = 1966; $tahun <= date('Y'); $tahun++): ?>
                  <option value="<?= $tahun ?>" <?= (old('angkatan', $alumni->angkatan) == $tahun) ? 'selected' : ''; ?>><?= $tahun ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="relative group">
              <label for="jurusan" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Jurusan <span class="text-rose-500">*</span></label>
              <select id="jurusan" name="jurusan" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all" required>
                <option value="" class="text-slate-400">Pilih Jurusan</option>
                <option value="Fisika" <?= (old('jurusan', $alumni->jurusan) == 'Fisika') ? 'selected' : ''; ?>>Fisika (A1)</option>
                <option value="Biologi" <?= (old('jurusan', $alumni->jurusan) == 'Biologi') ? 'selected' : ''; ?>>Biologi (A2)</option>
                <option value="Ilmu Sosial" <?= (old('jurusan', $alumni->jurusan) == 'Ilmu Sosial') ? 'selected' : ''; ?>>Ilmu Sosial (A3)</option>
                <option value="Ilmu Budaya" <?= (old('jurusan', $alumni->jurusan) == 'Ilmu Budaya') ? 'selected' : ''; ?>>Ilmu Budaya (A4)</option>
                <option value="IPA" <?= (old('jurusan', $alumni->jurusan) == 'IPA') ? 'selected' : ''; ?>>IPA</option>
                <option value="IPS" <?= (old('jurusan', $alumni->jurusan) == 'IPS') ? 'selected' : ''; ?>>IPS</option>
                <option value="Bahasa" <?= (old('jurusan', $alumni->jurusan) == 'Bahasa') ? 'selected' : ''; ?>>Bahasa</option>
                <option value="Umum" <?= (old('jurusan', $alumni->jurusan) == 'Umum') ? 'selected' : ''; ?>>Umum</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Part 3: Career -->
        <div class="space-y-8">
          <div class="flex items-center gap-x-4">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-900 text-white font-black shadow-xl shadow-blue-50 italic">03</span>
            <div class="h-px flex-1 bg-slate-100"></div>
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] whitespace-nowrap italic">Pekerjaan</h3>
          </div>

          <div class="grid grid-cols-1 gap-y-8">
            <div class="relative group">
              <label for="pekerjaan" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Sektor</label>
              <select id="pekerjaan" name="id_ref_pekerjaan" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all">
                <option value="" class="text-slate-400">Pilih Kategori</option>
                <?php
                $current_group = '';
                foreach ($pekerjaan_list as $p) {
                  if ($p->grup_pekerjaan != $current_group) {
                    if ($current_group != '') echo '</optgroup>';
                    $current_group = $p->grup_pekerjaan;
                    echo '<optgroup label="' . esc($current_group) . '">';
                  }
                  echo '<option value="' . $p->id_ref_pekerjaan . '" ' . ((old('id_ref_pekerjaan', $alumni->id_ref_pekerjaan) == $p->id_ref_pekerjaan) ? 'selected' : '') . '>' . esc($p->nama_pekerjaan) . '</option>';
                }
                if ($current_group != '') echo '</optgroup>';
                ?>
              </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="relative group">
                <label for="nama_perusahaan" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Instansi</label>
                <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="<?= old('nama_perusahaan', $alumni->nama_perusahaan); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all">
              </div>
              <div class="relative group">
                <label for="jabatan" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="<?= old('jabatan', $alumni->jabatan); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all">
              </div>
            </div>
          </div>
        </div>

        <!-- Part 4: Contact -->
        <div class="space-y-8">
          <div class="flex items-center gap-x-4">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-900 text-white font-black shadow-xl shadow-blue-50 italic">04</span>
            <div class="h-px flex-1 bg-slate-100"></div>
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] whitespace-nowrap italic">Kontak</h3>
          </div>

          <div class="grid grid-cols-1 gap-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="relative group">
                <label for="provinsi" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Provinsi <span class="text-rose-500">*</span></label>
                <select id="provinsi" name="provinsi_id" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all" required>
                  <option value="" class="text-slate-400">Pilih Provinsi</option>
                  <?php foreach ($provinsi as $prov): ?>
                    <option value="<?= $prov->id_provinsi; ?>" <?= (old('provinsi_id', $alumni->provinsi_id) == $prov->id_provinsi) ? 'selected' : ''; ?>><?= esc($prov->nama_provinsi); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="relative group">
                <label for="kabupaten" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Kota <span class="text-rose-500">*</span></label>
                <select id="kabupaten" name="kabupaten_id" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all" required>
                  <option value="" class="text-slate-400">Pilih Kota</option>
                  <?php foreach ($kabupaten as $kab): ?>
                    <option value="<?= $kab->id_kabupaten; ?>" <?= (old('kabupaten_id', $alumni->kabupaten_id) == $kab->id_kabupaten) ? 'selected' : ''; ?>><?= esc($kab->nama_kabupaten); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="relative group">
              <label for="alamat_domisili" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Alamat <span class="text-rose-500">*</span></label>
              <textarea id="alamat_domisili" name="alamat_domisili" rows="2" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all" required><?= old('alamat_domisili', $alumni->alamat_domisili); ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="relative group">
                <label for="no_telepon" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">WhatsApp <span class="text-rose-500">*</span></label>
                <input type="text" id="no_telepon" name="no_telepon" value="<?= old('no_telepon', $alumni->no_telepon); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-black transition-all" placeholder="08..." required>
              </div>
              <div class="relative group">
                <label for="email" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Email</label>
                <input type="email" id="email" name="email" value="<?= old('email', $alumni->email); ?>" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-slate-900 shadow-sm focus:border-blue-800 focus:ring-4 focus:ring-blue-800/10 sm:text-sm font-bold transition-all">
              </div>
            </div>

            <div class="space-y-4">
              <label class="text-[9px] font-black text-slate-400 tracking-widest ml-4 italic">Foto</label>
              <div id="foto-error-message" class="mb-2 text-red-500 text-xs text-center font-bold"></div>
              <div class="group relative flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-slate-200 px-6 py-12 hover:border-blue-800 hover:bg-slate-50/50 transition-all cursor-pointer overflow-hidden">
                <input id="foto" name="foto" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/png, image/jpg, image/jpeg">
                <div class="text-center">
                  <?php if (!empty($alumni->foto_profil)): ?>
                    <img id="preview-image-existing" src="<?= base_url('uploads/foto_alumni/' . $alumni->foto_profil); ?>" class="h-24 w-24 object-cover rounded-2xl mx-auto mb-4" alt="Existing Profile Photo">
                  <?php else: ?>
                    <i class="fas fa-cloud-upload-alt text-5xl text-slate-200 mb-4 group-hover:text-blue-800 transition-colors"></i>
                  <?php endif; ?>
                  <div class="flex text-sm leading-6 text-slate-600 justify-center">
                    <span class="relative font-black text-blue-900 group-hover:text-blue-800 tracking-widest text-[10px] uppercase">
                      Pilih File Baru
                    </span>
                  </div>
                  <p class="text-[9px] font-bold text-slate-300 tracking-widest mt-2 italic">PNG, JPG, JPEG • MAX 10MB</p>
                </div>
                <div id="preview-container" class="absolute inset-0 hidden bg-white rounded-3xl overflow-hidden p-2 z-20">
                  <img id="preview-image" src="#" class="h-full w-full object-contain rounded-2xl" alt="Preview">
                  <button type="button" onclick="document.getElementById('foto').value=''; document.getElementById('preview-container').classList.add('hidden'); document.getElementById('preview-image-existing').classList.remove('hidden');" class="absolute top-4 right-4 h-10 w-10 bg-slate-900/50 text-white rounded-full flex items-center justify-center hover:bg-slate-900 backdrop-blur-sm transition-all z-30">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-16 flex flex-col items-center gap-y-6">
          <p class="text-[9px] font-black text-slate-400 tracking-widest italic text-center px-8">Pastikan data yang bertanda bintang (*) telah benar.</p>
          <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-2xl bg-blue-900 px-16 py-5 text-xs font-black text-white shadow-2xl shadow-blue-900/20 hover:bg-blue-800 transition-all tracking-[0.3em] border-b-8 border-blue-950 active:border-b-0 active:translate-y-1">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('tanggal_lahir');
    if (dateInput) {
      dateInput.addEventListener('input', function(e) {
        let input = e.target.value.replace(/\D/g, '').substring(0, 8);
        if (input.length > 4) { input = input.substring(0, 2) + '-' + input.substring(2, 4) + '-' + input.substring(4); }
        else if (input.length > 2) { input = input.substring(0, 2) + '-' + input.substring(2); }
        e.target.value = input;
      });
    }

    const fotoInput = document.getElementById('foto');
    const fotoErrorMessage = document.getElementById('foto-error-message');
    const editForm = document.getElementById('editForm');

    const MAX_FILE_SIZE_BYTES = 10 * 1024 * 1024; // 10MB
    const ALLOWED_MIME_TYPES = ['image/png', 'image/jpeg', 'image/jpg'];

    function validateFotoFile(file) {
      if (!file) {
        return null; // File input is optional, no error if empty
      }

      if (!ALLOWED_MIME_TYPES.includes(file.type)) {
        return "Format file tidak didukung. Hanya PNG, JPG, JPEG yang diizinkan.";
      }

      if (file.size > MAX_FILE_SIZE_BYTES) {
        return "Ukuran file terlalu besar. Maksimum 10MB.";
      }

      return null;
    }

    if (fotoInput) {
      fotoInput.addEventListener('change', function(e) {
        const [file] = e.target.files;
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const previewImageExisting = document.getElementById('preview-image-existing');
        
        const validationError = validateFotoFile(file);

        if (validationError) {
          fotoErrorMessage.textContent = validationError;
          previewContainer.classList.add('hidden');
          if (previewImageExisting) previewImageExisting.classList.remove('hidden');
          fotoInput.value = ''; // Clear selected file
          return;
        } else {
          fotoErrorMessage.textContent = ''; // Clear any previous error
        }

        if (file) {
          const reader = new FileReader();
          reader.onload = e => {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
            if (previewImageExisting) previewImageExisting.classList.add('hidden');
          }
          reader.readAsDataURL(file);
        } else {
          previewContainer.classList.add('hidden');
          if (previewImageExisting) previewImageExisting.classList.remove('hidden');
        }
      });
    }

    if (editForm) {
      editForm.addEventListener('submit', function(e) {
        const file = fotoInput.files[0];
        const validationError = validateFotoFile(file);

        if (validationError) {
          e.preventDefault(); // Prevent form submission
          fotoErrorMessage.textContent = validationError;
        }
      });
    }

    // Dynamic Kabupaten loading
    const provinsiSelect = document.getElementById('provinsi');
    const kabupatenSelect = document.getElementById('kabupaten');

    if (provinsiSelect && kabupatenSelect) {
        provinsiSelect.addEventListener('change', function() {
            const provinsiId = this.value;
            if (provinsiId) {
                fetch(`<?= site_url('api/kabupaten/'); ?>${provinsiId}`)
                    .then(response => response.json())
                    .then(data => {
                        kabupatenSelect.innerHTML = '<option value="" class="text-slate-400">Pilih Kota</option>';
                        data.forEach(kab => {
                            const option = document.createElement('option');
                            option.value = kab.id_kabupaten;
                            option.textContent = kab.nama_kabupaten;
                            kabupatenSelect.appendChild(option);
                        });
                        // Pre-select current kabupaten if it exists and province matches
                        <?php if (!empty($alumni->kabupaten_id) && !empty($alumni->provinsi_id)): ?>
                            if (provinsiId == '<?= esc($alumni->provinsi_id); ?>') {
                                kabupatenSelect.value = '<?= esc($alumni->kabupaten_id); ?>';
                            }
                        <?php endif; ?>
                    });
            } else {
                kabupatenSelect.innerHTML = '<option value="" class="text-slate-400">Pilih Kota</option>';
            }
        });

        // Trigger change on load if an provinsi is already selected (for existing data)
        <?php if (!empty($alumni->provinsi_id)): ?>
            provinsiSelect.dispatchEvent(new Event('change'));
        <?php endif; ?>
    }
  });
</script>