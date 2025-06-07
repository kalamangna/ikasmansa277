    <style>
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; }
        #countdown {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #f44336;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div id="countdown">Sisa Waktu: <span id="time">02:00</span></div>
    


                <?php
                $link_url = base_url('launch');
                $whatsappMessage = urlencode($link_url);
                $whatsappLink = "https://wa.me/?text=" . $whatsappMessage;
                ?>

                <h2 class="font-center"><strong>Link Pendataan Alumni</strong></h2>
                <div class="text-center mb-3">
                  <a href="<?= base_url('qr_code?url=' . $link_url) ?>"><img height="90%" src="<?= base_url('qr_code?url=' . $link_url) ?>"></a>
                </div>



















    

    <script>
    $(document).ready(function() {
        // Format waktu dari detik ke MM:SS
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            seconds %= 60;
            return [
                minutes.toString().padStart(2, '0'),
                seconds.toString().padStart(2, '0')
            ].join(':');
        }

        // Fungsi untuk update countdown
        function updateCountdown() {
            $.getJSON("<?= site_url('launch/get_remaining_time') ?>", function(response) {
                if(response.is_active) {
                    $('#time').text(formatTime(response.remaining));
                    
                    // Warna merah ketika waktu < 30 detik
                    if(response.remaining < 30) {
                        $('#countdown').css('background', '#ff0000');
                    }
                    
                    setTimeout(updateCountdown, 1000);
                } else {
                    // Waktu habis
                    $('#time').text('00:00');
                    $('#countdown').css('background', '#ff0000').text('WAKTU HABIS');
                    $('#submitBtn').prop('disabled', true);
                    alert('Waktu pendataan telah habis! Form tidak dapat disubmit.');
                }
            }).fail(function() {
                setTimeout(updateCountdown, 1000);
            });
        }

        // Mulai countdown
        updateCountdown();

        // Handle form submission ketika waktu habis
        $('#dataForm').submit(function(e) {
            $.ajax({
                url: "<?= site_url('launch/get_remaining_time') ?>",
                async: false,
                dataType: 'json',
                success: function(response) {
                    if(!response.is_active) {
                        e.preventDefault();
                        alert('Waktu pendataan telah habis! Data tidak dapat disimpan.');
                    }
                }
            });
        });
    });
    </script>
