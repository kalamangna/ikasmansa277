<?php $url = "https://example.com/user?id=123"; ?>
<img src="<?= site_url('qrcode/generate/' . urlencode($url)) ?>" alt="QR Code">