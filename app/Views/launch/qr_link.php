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

<div class="max-w-xl mx-auto py-12 px-6">
    <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-200 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-blue-900"></div>
        <div class="p-12">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center p-4 bg-slate-50 rounded-2xl mb-8 shadow-inner border border-slate-100">
                    <img src="<?php echo base_url("images/logo_ika1.png") ?>" class="h-12 w-auto" alt="Logo">
                </div>
                <h2 class="text-3xl font-black text-blue-900 uppercase italic tracking-tighter leading-none">Link Daftar</h2>
                <p class="text-[10px] text-slate-400 font-bold mt-4 uppercase tracking-[0.3em]">Pendaftaran Online</p>
            </div>

            <?php
            $link_url = base_url('launch');
            ?>

            <div class="flex flex-col items-center">
                <div class="p-6 bg-white rounded-[2.5rem] border-4 border-slate-50 shadow-2xl relative group mb-12">
                    <div class="absolute -inset-2 bg-gradient-to-tr from-blue-900 to-yellow-400 rounded-[2.8rem] opacity-5 group-hover:opacity-10 transition-opacity blur-lg"></div>
                    <a href="<?= base_url('qr_code?url=' . $link_url) ?>" class="block">
                        <img src="<?= base_url('qr_code?url=' . $link_url) ?>" class="relative h-64 w-64 rounded-[2rem] shadow-inner" alt="QR">
                    </a>
                </div>

                <div class="w-full space-y-4">
                    <button onclick="copyLink('<?= $link_url ?>')" class="w-full flex items-center justify-center gap-x-3 rounded-2xl bg-blue-900 px-6 py-5 text-xs font-black text-white shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all uppercase tracking-[0.2em] border-b-4 border-blue-950 active:border-b-0 active:translate-y-1">
                        <i class="fa fa-copy text-yellow-400"></i> Copy
                    </button>
                    
                    <?php $whatsappLink = "https://wa.me/?text=" . urlencode("Halo Alumni SMAN 1/277 Sinjai! Silakan daftar melalui link ini: " . $link_url); ?>
                    <a href="<?= $whatsappLink ?>" target="_blank" class="w-full flex items-center justify-center gap-x-3 rounded-2xl bg-emerald-600 px-6 py-5 text-xs font-black text-white shadow-xl shadow-emerald-600/20 hover:bg-emerald-500 transition-all uppercase tracking-[0.2em] border-b-4 border-emerald-800 active:border-b-0 active:translate-y-1 italic">
                        <i class="fab fa-whatsapp text-lg"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 px-12 py-6 border-t border-slate-100 text-center">
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">Scan QR</p>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        seconds %= 60;
        return [
            minutes.toString().padStart(2, '0'),
            seconds.toString().padStart(2, '0')
        ].join(':');
    }

    function updateCountdown() {
        $.getJSON("<?= site_url('launch/get_remaining_time') ?>", function(response) {
            if(response.is_active) {
                $('#time').text(formatTime(response.remaining));
                if(response.remaining < 30) {
                    $('#countdown > div').addClass('border-red-600 ring-red-500/20').removeClass('border-blue-900');
                }
                setTimeout(updateCountdown, 1000);
            } else {
                $('#time').text('00:00');
                $('#countdown > div').addClass('bg-red-600').removeClass('bg-blue-950');
                alert('Selesai.');
                window.location.reload();
            }
        }).fail(function() {
            setTimeout(updateCountdown, 1000);
        });
    }

    updateCountdown();
});

function copyLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        alert('Link disalin!');
    });
}
</script>