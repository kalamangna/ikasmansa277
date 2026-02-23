<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Qrcode {

    public function generate($data, $filename = false, $size = 4, $level = 'H', $frameSize = 2) {
        require_once(APPPATH . 'libraries/Phpqrcode/qrlib.php');

        if ($filename) {
            QRcode::png($data, $filename, $level, $size, $frameSize);
        } else {
            QRcode::png($data, null, $level, $size, $frameSize);
        }
    }
}
