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

<!-- dataTables -->
<script src="<?= base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/datatables/dataTables.bootstrap5.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#alumniTable').DataTable();
    });

    $(document).ready(function() {
        $('#dashboardTable').DataTable({
            "paging": false,       // Nonaktifkan pagination
            "searching": false,    // Nonaktifkan search
            "info": false,         // Nonaktifkan info "Showing X of Y entries"
            "ordering": true,      // Biarkan sorting aktif (opsional)
            "dom": 't'            // Hanya tampilkan tabel saja (tanpa kontrol lainnya)
        });
});
</script>

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

<?php
$hidden_counter = isset($hidden_counter) ? $hidden_counter : false;
if ($hidden_counter == false) {
  $this->Counter_model->track_visit();
}

?>


<!-- Validasi form dengan Bootstrap -->
<script>
  (function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();

          // Fokus ke field pertama yang invalid
          const firstInvalid = form.querySelector(':invalid');
          if (firstInvalid) {
            firstInvalid.focus();
            // scroll ke posisi (jika dibutuhkan)
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


<?php
// $upload_path = FCPATH . 'pendataan_alumni/uploads/alumni/';
// echo $upload_path;die();
?>