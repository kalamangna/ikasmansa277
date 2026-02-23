<style>
  /* Basic centering for the 404 content if not already handled by Tailwind */
  .error-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 150px); /* Adjust based on header/footer height */
    text-align: center;
    padding: 2rem;
  }
  .error-code {
    font-size: 6rem;
    font-weight: bold;
    color: #4a5568; /* Tailwind gray-700 */
  }
  .error-message {
    font-size: 1.5rem;
    margin-top: 1rem;
    color: #2d3748; /* Tailwind gray-800 */
  }
  .helpful-links {
    margin-top: 2rem;
  }
  .helpful-links a {
    display: inline-block;
    margin: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    background-color: #2b6cb0; /* Tailwind blue-700 */
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.2s;
  }
  .helpful-links a:hover {
    background-color: #2c5282; /* Tailwind blue-800 */
  }
</style>

<div class="error-container">
  <h1 class="error-code text-blue-900">404</h1>
  <p class="error-message text-blue-800"><?= $message ?? 'Maaf, halaman yang Anda cari tidak ditemukan.' ?></p>
  <p class="mt-4 text-slate-600">Sepertinya Anda tersesat. Jangan khawatir, kami akan membantu Anda kembali ke jalur yang benar.</p>
  
  <?php if (isset($helpful_links) && !empty($helpful_links)): ?>
    <div class="helpful-links">
      <?php foreach ($helpful_links as $text => $url): ?>
        <a href="<?= $url ?>" class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-xl shadow-md">
          <?= $text ?>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
