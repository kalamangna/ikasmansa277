</div> <!-- tutup container -->

<footer class="bg-light text-center py-3 mt-4">
  <div class="container">
    <small>&copy; 2025 IKA SMANSA / 277 Sinjai. All rights reserved.
    </small>
  </div>
</footer>


<!-- Bootstrap JS dan dependensi Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>

<!-- manampikan script untuk menampilkan kabupaten setelah memilih provinsi -->
<?php if (isset($ajax_kabupaten)): ?>
  <script>
    $(document).ready(function() {
      $('#provinsi').change(function() {
        var provinsi_id = $(this).val();
        if (provinsi_id) {
          $.ajax({
            url: '<?php echo site_url('alumni/get_kabupaten_ajax'); ?>',
            type: 'POST',
            data: {
              provinsi_id: provinsi_id
            },
            dataType: 'json',
            success: function(data) {
              $('#kabupaten').empty();
              $('#kabupaten').append('<option value="">Pilih Kabupaten/Kota</option>');
              $.each(data, function(key, value) {
                $('#kabupaten').append('<option value="' + value.id_kabupaten + '">' + value.nama_kabupaten + '</option>');
              });
            }
          });
        } else {
          $('#kabupaten').empty();
          $('#kabupaten').append('<option value="">Pilih Kabupaten/Kota</option>');
        }
      });

      // Jika di form edit, bisa set kabupaten yang sudah dipilih
      <?php if (isset($alumni) && $alumni->kabupaten_id): ?>
        var selectedKabupaten = '<?php echo $alumni->kabupaten_id; ?>';
        var provinsi_id = $('#provinsi').val();
        if (provinsi_id) {
          $.ajax({
            url: '<?php echo site_url('alumni/get_kabupaten_ajax'); ?>',
            type: 'POST',
            data: {
              provinsi_id: provinsi_id
            },
            dataType: 'json',
            success: function(data) {
              $('#kabupaten').empty();
              $('#kabupaten').append('<option value="">Pilih Kabupaten/Kota</option>');
              $.each(data, function(key, value) {
                var selected = (value.id_kabupaten == selectedKabupaten) ? 'selected' : '';
                $('#kabupaten').append('<option value="' + value.id_kabupaten + '" ' + selected + '>' + value.nama_kabupaten + '</option>');
              });
            }
          });
        }
      <?php endif; ?>
    });
  </script>
<?php endif; ?>

</body>

</html>