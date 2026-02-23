<?php
$session = session();
?>
<div id="countdown" class="fixed top-8 right-8 z-50">
    <div class="bg-blue-950 text-white px-8 py-4 rounded-[1.5rem] shadow-2xl border-b-4 border-red-600 flex items-center gap-x-5 ring-8 ring-blue-900/10 backdrop-blur-lg">
        <div class="h-12 w-12 rounded-2xl bg-white/5 flex items-center justify-center border border-white/10 shadow-inner">
            <i class="fa fa-clock text-yellow-400 animate-pulse text-lg"></i>
        </div>
        <div>
            <p class="text-[9px] font-black text-blue-300 uppercase tracking-[0.2em] leading-none mb-1.5 italic">Sisa Waktu</p>
            <p class="text-xl font-black tabular-nums tracking-tighter leading-none text-white italic"><span id="time">00:00</span></p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto mb-20">
  <div class="mb-10 text-center">
    <div class="inline-flex items-center justify-center p-4 bg-white rounded-3xl shadow-xl mb-8 border border-slate-100">
      <img src="<?= base_url("images/ika.png") ?>" class="h-16 w-auto" alt="Logo">
    </div>
    <h1 class="text-4xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">Registrasi</h1>
    <p class="text-sm text-slate-400 font-bold mt-4 uppercase tracking-[0.3em]">Pendataan Online</p>
  </div>

  <?php if ($session->getFlashdata('error')): ?>
    <div class="mb-10 rounded-2xl bg-red-50 p-6 border-l-8 border-red-600 shadow-xl flex items-center gap-5">
      <div class="h-12 w-12 rounded-xl bg-red-600 flex items-center justify-center text-white shadow-lg"><i class="fa fa-triangle-exclamation text-xl"></i></div>
      <p class="text-sm font-black text-slate-800 uppercase tracking-tight"><?= esc($session->getFlashdata('error')) ?></p>
    </div>
  <?php endif; ?>

  <div class="bg-white shadow-2xl shadow-blue-900/5 rounded-[3rem] border border-slate-200 overflow-hidden">
    <!-- Privacy -->
    <div class="bg-blue-900 px-10 py-8 flex flex-col md:flex-row items-center gap-6 relative overflow-hidden">
      <div class="absolute -right-10 -top-10 opacity-10"><i class="fa fa-shield-halved text-[10rem] text-white"></i></div>
      <div class="h-14 w-14 rounded-2xl bg-white/10 flex items-center justify-center text-yellow-400 backdrop-blur-md ring-1 ring-white/20 flex-shrink-0">
        <i class="fa fa-user-shield text-2xl"></i>
      </div>
      <div class="text-center md:text-left relative z-10">
        <h3 class="text-xs font-black text-yellow-400 uppercase tracking-[0.3em] mb-1">Privasi</h3>
        <p class="text-[10px] text-blue-100 font-medium uppercase tracking-widest leading-relaxed italic">Data Anda bersifat konfidensial dan hanya digunakan untuk keperluan internal organisasi.</p>
      </div>
    </div>

    <div class="p-10 lg:p-16">
      <form method="post" action="<?= site_url('alumni/save?ut=' . esc(request()->getGet('ut'))); ?>" enctype="multipart/form-data" class="needs-validation space-y-16" id="dataForm" novalidate>
        <?= csrf_field() ?>
        
        <!-- Part 1: Profile -->
        <div class="space-y-10">
          <div class="flex items-center gap-x-5">
            <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl italic font-black text-xl">01</div>
            <h3 class="text-xl font-black text-slate-900 uppercase italic leading-none">Profil</h3>
          </div>

          <div class="grid grid-cols-1 gap-y-10">
            <div class="relative group">
              <label for="nama_lengkap" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Nama Lengkap <span class="text-red-600">*</span></label>
              <input type="text" id="nama_lengkap" name="nama_lengkap" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="nama_panggilan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Panggilan</label>
                <input type="text" id="nama_panggilan" name="nama_panggilan" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all">
              </div>
              <div class="bg-slate-50 rounded-2xl p-5 ring-1 ring-slate-200 flex flex-col justify-center">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-2 italic">Gender <span class="text-red-600">*</span></span>
                <div class="flex gap-x-10 ml-2">
                  <label class="flex items-center gap-x-3 cursor-pointer group">
                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="h-5 w-5 border-slate-300 text-blue-900 focus:ring-blue-900" required>
                    <span class="text-xs font-black text-slate-600 group-hover:text-blue-900 uppercase transition-colors">Laki-laki</span>
                  </label>
                  <label class="flex items-center gap-x-3 cursor-pointer group">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="h-5 w-5 border-slate-300 text-blue-900 focus:ring-blue-900">
                    <span class="text-xs font-black text-slate-600 group-hover:text-blue-900 uppercase transition-colors">Perempuan</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="tempat_lahir" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Kota Lahir <span class="text-red-600">*</span></label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required>
              </div>
              <div class="relative group">
                <label for="tanggal_lahir" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Tgl Lahir <span class="text-red-600">*</span></label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all uppercase" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Part 2: Contact -->
        <div class="space-y-10">
          <div class="flex items-center gap-x-5">
            <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl italic font-black text-xl">02</div>
            <h3 class="text-xl font-black text-slate-900 uppercase italic leading-none">Kontak</h3>
          </div>

          <div class="grid grid-cols-1 gap-y-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="provinsi" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Provinsi <span class="text-red-600">*</span></label>
                <select id="provinsi" name="provinsi_id" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required>
                  <option value="">PILIH PROVINSI</option>
                  <?php foreach ($provinsi as $prov): ?>
                    <option value="<?= $prov->id_provinsi; ?>"><?= esc($prov->nama_provinsi); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="relative group">
                <label for="kabupaten" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Kota <span class="text-red-600">*</span></label>
                <select id="kabupaten" name="kabupaten_id" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required>
                  <option value="">PILIH KOTA</option>
                </select>
              </div>
            </div>

            <div class="relative group">
              <label for="alamat_domisili" class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Alamat <span class="text-red-600">*</span></label>
              <textarea id="alamat_domisili" name="alamat_domisili" rows="2" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required></textarea>
            </div>

            <div class="relative group">
              <label for="no_telepon" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">WhatsApp <span class="text-red-600">*</span></label>
              <input type="text" id="no_telepon" name="no_telepon" placeholder="08..." class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black tabular-nums transition-all" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="email" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Email <span class="text-red-600">*</span></label>
                <input type="email" id="email" name="email" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all uppercase" required>
              </div>
              <div class="relative group">
                <label for="password" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Password <span class="text-red-600">*</span></label>
                <input type="password" id="password" name="password" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Part 3: Academic -->
        <div class="space-y-10">
          <div class="flex items-center gap-x-5">
            <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl italic font-black text-xl">03</div>
            <h3 class="text-xl font-black text-slate-900 uppercase italic leading-none">Akademik</h3>
          </div>

          <div class="grid grid-cols-1 gap-y-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="angkatan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Angkatan <span class="text-red-600">*</span></label>
                <select id="angkatan" name="angkatan" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all" required>
                  <option value="">PILIH TAHUN</option>
                  <?php for ($tahun = 1966; $tahun <= date('Y'); $tahun++): ?>
                    <option value="<?= $tahun ?>"><?= $tahun ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="relative group">
                <label for="jurusan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Jurusan <span class="text-red-600">*</span></label>
                <select id="jurusan" name="jurusan" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all italic" required>
                  <option value="">PILIH JURUSAN</option>
                  <option value="Fisika">FISIKA (A1)</option>
                  <option value="Biologi">BIOLOGI (A2)</option>
                  <option value="Ilmu Sosial">ILMU SOSIAL (A3)</option>
                  <option value="Ilmu Budaya">ILMU BUDAYA (A4)</option>
                  <option value="IPA">IPA</option>
                  <option value="IPS">IPS</option>
                  <option value="Bahasa">BAHASA</option>
                  <option value="Umum">UMUM / LAINNYA</option>
                </select>
              </div>
            </div>

            <div class="relative group">
              <label for="pekerjaan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Pekerjaan</label>
              <select id="pekerjaan" name="id_ref_pekerjaan" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all">
                <option value="">PILIH KATEGORI</option>
                <?php
                $current_group = '';
                foreach ($pekerjaan_list as $p) {
                  if ($p->grup_pekerjaan != $current_group) {
                    if ($current_group != '') echo '</optgroup>';
                    $current_group = $p->grup_pekerjaan;
                    echo '<optgroup label="' . esc($current_group) . '">';
                  }
                  echo '<option value="' . $p->id_ref_pekerjaan . '">' . esc($p->nama_pekerjaan) . '</option>';
                }
                if ($current_group != '') echo '</optgroup>';
                ?>
              </select>
            </div>

            <div class="space-y-4">
              <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-6 italic text-blue-900">Foto <span class="text-red-600">*</span></label>
              <div class="group relative flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-slate-200 px-6 py-12 hover:border-blue-900 hover:bg-slate-50 transition-all cursor-pointer">
                <div class="text-center pointer-events-none">
                  <i class="fas fa-cloud-upload-alt text-5xl text-slate-200 mb-4 group-hover:text-blue-900 transition-colors"></i>
                  <div class="flex text-sm leading-6 text-slate-600 justify-center">
                    <label for="foto" class="relative cursor-pointer font-black text-blue-900 hover:text-blue-800 uppercase tracking-widest text-[10px]">
                      <span>Pilih File</span>
                      <input id="foto" name="foto" type="file" class="sr-only" accept="image/*" required>
                    </label>
                  </div>
                  <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest mt-2 italic">Master: JPG / PNG up to 10MB</p>
                </div>
                <div id="preview-container" class="absolute inset-0 hidden bg-white rounded-3xl overflow-hidden p-2">
                  <img id="preview-image" src="#" class="h-full w-full object-contain rounded-2xl" alt="Preview">
                  <button type="button" onclick="document.getElementById('foto').value=''; document.getElementById('preview-container').classList.add('hidden')" class="absolute top-4 right-4 h-10 w-10 bg-slate-900/50 text-white rounded-full flex items-center justify-center hover:bg-slate-900 backdrop-blur-sm transition-all"><i class="fa fa-times"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-16 flex flex-col items-center gap-y-8">
          <div class="flex items-center gap-3">
            <div class="h-px w-12 bg-slate-100"></div>
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] italic">Selesai</p>
            <div class="h-px w-12 bg-slate-100"></div>
          </div>
          <button type="submit" class="w-full md:w-auto px-20 py-6 bg-blue-900 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.3em] shadow-2xl shadow-blue-900/30 hover:bg-blue-800 transition-all border-b-8 border-blue-950 active:border-b-0 active:translate-y-1 transform hover:-translate-y-1">
            Simpan &rarr;
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        seconds %= 60;
        return [minutes.toString().padStart(2, '0'), seconds.toString().padStart(2, '0')].join(':');
    }

    function updateCountdown() {
        $.getJSON("<?= site_url('launch/get_remaining_time') ?>", function(response) {
            if(response.is_active) {
                $('#time').text(formatTime(response.remaining));
                if(response.remaining < 30) $('#countdown > div').addClass('border-red-600').removeClass('border-blue-950');
                setTimeout(updateCountdown, 1000);
            } else {
                $('#time').text('00:00');
                $('#countdown > div').addClass('bg-red-600').text('SELESAI');
                alert('Selesai.');
                window.location.href = "<?= base_url('launch/end') ?>";
            }
        });
    }
    updateCountdown();

    $('#foto').on('change', function(e) {
        const [file] = e.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                $('#preview-image').attr('src', e.target.result);
                $('#preview-container').removeClass('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>