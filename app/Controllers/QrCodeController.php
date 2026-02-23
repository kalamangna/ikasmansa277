<?php

namespace App\Controllers;

use App\Models\QrCodeModel;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QrCodeController extends BaseController
{
    protected $qrCodeModel;

    public function __construct()
    {
        $this->qrCodeModel = new QrCodeModel();
    }

    public function index()
    {
        $url = $this->request->getGet('url');
        if (!$url) {
            return $this->response->setBody("Parameter 'url' tidak ditemukan.");
        }

        $filename = 'qr_' . md5($url) . '.png';
        $folder   = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'qr_code' . DIRECTORY_SEPARATOR;
        $filepath = $folder . $filename;

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $qrData = $this->qrCodeModel->getByContent($url);
        if ($qrData && file_exists($filepath)) {
            $mimeType = 'image/png';
            return $this->response
                ->setHeader('Content-Type', $mimeType)
                ->setBody(file_get_contents($filepath));
        }

        // Generate QR Code using chillerlan/php-qrcode
        try {
            $options = new QROptions([
                'version'    => 10,
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'   => QRCode::ECC_H,
                'scale'      => 5,
                'imageBase64' => false,
            ]);

            $pngData = (new QRCode($options))->render($url);

            file_put_contents($filepath, $pngData);
            
            if (!$qrData) {
                $dataDb = [
                    'content'  => $url,
                    'filename' => $filename
                ];
                $this->qrCodeModel->insertQrCode($dataDb);
            }

            return $this->response
                ->setHeader('Content-Type', 'image/png')
                ->setBody($pngData);

        } catch (\Exception $e) {
            return $this->response->setBody("Gagal generate QR Code: " . $e->getMessage());
        }
    }
}
