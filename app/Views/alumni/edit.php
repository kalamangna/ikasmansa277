<div class="max-w-4xl mx-auto">
  <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-y-6">
    <div>
      <h1 class="text-3xl font-black text-blue-900 tracking-tighter italic leading-none uppercase">Edit Alumni</h1>
      <p class="text-sm text-slate-400 font-bold mt-2 uppercase tracking-widest leading-none">Update profil</p>
    </div>
    <div class="flex items-center gap-x-3">
      <a href="<?= site_url('alumni/detail/' . $alumni->id_alumni) ?>" class="inline-flex items-center gap-x-3 rounded-2xl bg-white px-6 py-3.5 text-xs font-black text-slate-500 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all tracking-widest group">
        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
        Batal
      </a>
    </div>
  </div>

  <div class="bg-white shadow-2xl shadow-blue-900/5 rounded-[2.5rem] border border-slate-200 overflow-hidden mb-16">
    <div class="p-10 lg:p-16">
      <form method="post" action="<?php echo site_url('alumni/update/' . $alumni->id_alumni); ?>" class="needs-validation space-y-16" novalidate enctype="multipart/form-data">
        
        <!-- Part 1: Personal -->
        <div class="space-y-10">
          <div class="flex items-center gap-x-5">
            <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl shadow-blue-900/20 italic font-black text-xl">01</div>
            <div>
              <h3 class="text-xl font-black text-slate-900 italic leading-none uppercase">Personal</h3>
              <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Data identitas resmi</p>
            </div>
          </div>

          <div class="grid grid-cols-1 gap-y-10">
            <div class="relative group">
              <label for="nama_lengkap" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Nama Lengkap <span class="text-red-600">*</span></label>
              <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $alumni->nama_lengkap; ?>" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="nama_panggilan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Panggilan</label>
                <input type="text" id="nama_panggilan" name="nama_panggilan" value="<?php echo set_value('nama_panggilan', $alumni->nama_panggilan ?? ''); ?>" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all">
              </div>
              <div class="bg-slate-50/50 rounded-2xl p-5 ring-1 ring-slate-200 flex flex-col justify-center">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-2 italic">Gender <span class="text-red-600">*</span></span>
                <div class="flex gap-x-10 ml-2">
                  <label class="flex items-center gap-x-3 cursor-pointer group">
                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="h-5 w-5 border-slate-300 text-blue-900 focus:ring-blue-900" <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin) == 'Laki-laki' ? 'checked' : ''; ?> required>
                    <span class="text-xs font-black text-slate-600 group-hover:text-blue-900 transition-colors uppercase">Laki-laki</span>
                  </label>
                  <label class="flex items-center gap-x-3 cursor-pointer group">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="h-5 w-5 border-slate-300 text-blue-900 focus:ring-blue-900" <?php echo set_value('jenis_kelamin', $alumni->jenis_kelamin) == 'Perempuan' ? 'checked' : ''; ?>>
                    <span class="text-xs font-black text-slate-600 group-hover:text-blue-900 transition-colors uppercase">Perempuan</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="tempat_lahir" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Kota Lahir <span class="text-red-600">*</span></label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?php echo $alumni->tempat_lahir; ?>" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all" required>
              </div>
              <div class="relative group">
                <label for="tanggal_lahir" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Tgl Lahir <span class="text-red-600">*</span></label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $alumni->tanggal_lahir; ?>" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black tabular-nums transition-all italic" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Part 2: Contact -->
        <div class="space-y-10">
          <div class="flex items-center gap-x-5">
            <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl shadow-blue-900/20 italic font-black text-xl">02</div>
            <div>
              <h3 class="text-xl font-black text-slate-900 italic leading-none uppercase">Kontak</h3>
              <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Informasi domisili</p>
            </div>
          </div>

          <div class="grid grid-cols-1 gap-y-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="provinsi" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Provinsi <span class="text-red-600">*</span></label>
                <select id="provinsi" name="provinsi_id" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required>
                  <option value="">PILIH PROVINSI</option>
                  <?php foreach ($provinsi as $prov): ?>
                    <option value="<?php echo $prov->id_provinsi; ?>" <?php echo ($prov->id_provinsi == $alumni->provinsi_id) ? 'selected' : ''; ?>><?php echo $prov->nama_provinsi; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="relative group">
                <label for="kabupaten" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Kota <span class="text-red-600">*</span></label>
                <select id="kabupaten" name="kabupaten_id" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required>
                  <option value="">PILIH KOTA</option>
                  <?php foreach ($kabupaten as $kab): ?>
                    <option value="<?php echo $kab->id_kabupaten; ?>" <?php echo ($kab->id_kabupaten == $alumni->kabupaten_id) ? 'selected' : ''; ?>><?php echo $kab->nama_kabupaten; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="relative group">
              <label for="alamat_domisili" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Alamat <span class="text-red-600">*</span></label>
              <textarea id="alamat_domisili" name="alamat_domisili" rows="3" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all" required><?php echo $alumni->alamat_domisili; ?></textarea>
            </div>

            <div class="relative group">
              <label for="no_telepon" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">WhatsApp <span class="text-red-600">*</span></label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-emerald-500">
                  <i class="fab fa-whatsapp text-lg"></i>
                </div>
                <input type="text" id="no_telepon" name="no_telepon" value="<?php echo $alumni->no_telepon; ?>" class="block w-full rounded-2xl border-slate-200 py-5 pl-14 pr-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black tabular-nums transition-all" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Part 3: Education & Career -->
        <div class="space-y-16">
          <div class="space-y-10">
            <div class="flex items-center gap-x-5">
              <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl shadow-blue-900/20 italic font-black text-xl">03</div>
              <div>
                <h3 class="text-xl font-black text-slate-900 italic leading-none uppercase">Akademik</h3>
                <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Informasi angkatan</p>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group">
                <label for="angkatan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Angkatan <span class="text-red-600">*</span></label>
                <select id="angkatan" name="angkatan" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all" required>
                  <option value="">PILIH ANGKATAN</option>
                  <?php for ($tahun = 1966; $tahun <= date('Y'); $tahun++): ?>
                    <option value="<?= $tahun ?>" <?= $tahun == $alumni->angkatan ? 'selected' : '' ?>><?= $tahun ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="relative group">
                <label for="jurusan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Jurusan <span class="text-red-600">*</span></label>
                <select id="jurusan" name="jurusan" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all italic" required>
                  <option value="">PILIH JURUSAN</option>
                  <option value="Fisika" <?php echo ("Fisika" == $alumni->jurusan) ? 'selected' : ''; ?>>FISIKA (A1)</option>
                  <option value="Biologi" <?php echo ("Biologi" == $alumni->jurusan) ? 'selected' : ''; ?>>BIOLOGI (A2)</option>
                  <option value="Ilmu Sosial" <?php echo ("Sosial" == $alumni->jurusan) ? 'selected' : ''; ?>>ILMU SOSIAL (A3)</option>
                  <option value="Ilmu Budaya" <?php echo ("Budaya" == $alumni->jurusan) ? 'selected' : ''; ?>>ILMU BUDAYA (A4)</option>
                  <option value="IPA" <?php echo ("IPA" == $alumni->jurusan) ? 'selected' : ''; ?>>IPA</option>
                  <option value="IPS" <?php echo ("IPS" == $alumni->jurusan) ? 'selected' : ''; ?>>IPS</option>
                  <option value="Bahasa" <?php echo ("Bahasa" == $alumni->jurusan) ? 'selected' : ''; ?>>BAHASA</option>
                  <option value="Umum" <?php echo ("Umum" == $alumni->jurusan) ? 'selected' : ''; ?>>UMUM / LAINNYA</option>
                </select>
              </div>
            </div>
          </div>

          <div class="space-y-10">
            <div class="flex items-center gap-x-5">
              <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl shadow-blue-900/20 italic font-black text-xl">04</div>
              <div>
                <h3 class="text-xl font-black text-blue-900 italic leading-none uppercase">Pekerjaan</h3>
                <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Informasi karir</p>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
              <div class="relative group md:col-span-2">
                <label for="pekerjaan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Kategori</label>
                <select id="pekerjaan" name="id_ref_pekerjaan" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black uppercase transition-all">
                  <option value="">PILIH KATEGORI</option>
                  <?php foreach ($pekerjaan_list as $p): ?>
                    <option value="<?php echo $p->id_ref_pekerjaan; ?>" <?php echo ($p->id_ref_pekerjaan == ($alumni->id_ref_pekerjaan ?? null)) ? 'selected' : ''; ?>>
                      <?php echo $p->nama_pekerjaan; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="relative group">
                <label for="nama_perusahaan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Instansi</label>
                <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="<?php echo $alumni->nama_perusahaan; ?>" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all uppercase">
              </div>
              <div class="relative group">
                <label for="jabatan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="<?php echo $alumni->jabatan; ?>" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all uppercase">
              </div>
              <div class="relative group md:col-span-2">
                <label for="alamat_kantor" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Alamat Kantor</label>
                <textarea id="alamat_kantor" name="alamat_kantor" rows="2" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black transition-all uppercase"><?php echo $alumni->alamat_kantor; ?></textarea>
              </div>
            </div>
          </div>

          <div class="space-y-10">
            <div class="flex items-center gap-x-5">
              <div class="h-12 w-12 rounded-2xl bg-blue-900 flex items-center justify-center text-yellow-400 shadow-xl shadow-blue-900/20 italic font-black text-xl">05</div>
              <div>
                <h3 class="text-xl font-black text-slate-900 uppercase italic leading-none">Lainnya</h3>
                <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Keterangan tambahan</p>
              </div>
            </div>
            
            <div class="space-y-10">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="flex items-start gap-x-5 cursor-pointer group p-6 rounded-3xl border-2 border-slate-100 hover:border-blue-900 hover:bg-slate-50 transition-all">
                  <div class="flex h-6 items-center">
                    <input type="checkbox" id="bergabung_komunitas" name="bergabung_komunitas" value="1" class="h-6 w-6 rounded-lg border-slate-300 text-blue-900 focus:ring-blue-900" <?php echo ($alumni->bergabung_komunitas) ? 'checked' : ''; ?>>
                  </div>
                  <div class="text-sm">
                    <p class="font-black text-slate-800 uppercase tracking-tight leading-none mb-2 italic">Komunitas</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Bergabung dalam grup resmi.</p>
                  </div>
                </label>

                <label class="flex items-start gap-x-5 cursor-pointer group p-6 rounded-3xl border-2 border-slate-100 hover:border-blue-900 hover:bg-slate-50 transition-all">
                  <div class="flex h-6 items-center">
                    <input type="checkbox" id="partisipasi_kegiatan" name="partisipasi_kegiatan" value="1" class="h-6 w-6 rounded-lg border-slate-300 text-blue-900 focus:ring-blue-900" <?php echo ($alumni->partisipasi_kegiatan) ? 'checked' : ''; ?>>
                  </div>
                  <div class="text-sm">
                    <p class="font-black text-slate-800 uppercase tracking-tight leading-none mb-2 italic">Kegiatan</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Partisipasi agenda alumni.</p>
                  </div>
                </label>
              </div>

              <div class="relative group">
                <label for="saran_masukan" class="absolute -top-2.5 left-6 px-2 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-900 transition-colors">Saran</label>
                <textarea id="saran_masukan" name="saran_masukan" rows="4" class="block w-full rounded-2xl border-slate-200 py-5 px-8 text-slate-900 shadow-sm focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 sm:text-sm font-black italic transition-all uppercase"><?php echo $alumni->saran_masukan; ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <input type="hidden" name="id_pekerjaan" value="<?= $alumni->nama_perusahaan ?>">

        <div class="mt-16 pt-12 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
          <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] italic max-w-sm leading-relaxed">Data akan diverifikasi otomatis oleh sistem.</p>
          <button type="submit" class="w-full md:w-auto inline-flex justify-center rounded-2xl bg-blue-900 px-12 py-5 text-xs font-black text-white shadow-2xl shadow-blue-900/30 hover:bg-blue-800 transition-all tracking-[0.3em] border-b-8 border-blue-950 active:border-b-0 active:translate-y-1 uppercase tracking-widest">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // No-op script to satisfy existing structure
  });
</script>