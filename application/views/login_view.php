<div class="row justify-content-center">
  <div class="col-md-6 col-lg-4">
    <h2 class="mb-4 text-center">Login Alumni</h2>

    <div class="card shadow mb-3">
      <div class="card-body">
        <form method="post" action="<?php echo site_url('auth/login'); ?>">
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>

    <?php if (isset($error)) { ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
      </div>
    <?php } ?>
  </div>
</div>