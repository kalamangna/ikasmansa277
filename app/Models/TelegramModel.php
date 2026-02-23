<?php

namespace App\Models;

use CodeIgniter\Model;

class TelegramModel extends Model
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        parent::__construct();
        
        $this->botToken = env('TELEGRAM_BOT_TOKEN') ?? (defined('TELEGRAM_BOT_TOKEN') ? TELEGRAM_BOT_TOKEN : '');
        $this->chatId   = env('TELEGRAM_CHAT_ID') ?? (defined('TELEGRAM_CHAT_ID') ? TELEGRAM_CHAT_ID : '');
    }

    /**
     * Mengirim pesan ke Telegram
     */
    public function sendMessage(string $text, string $parseMode = 'HTML'): bool
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            return false;
        }

        $data = [
            'chat_id'    => $this->chatId,
            'text'       => $text,
            'parse_mode' => $parseMode
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => "https://api.telegram.org/bot{$this->botToken}/sendMessage",
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 5
        ]);
        
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
         
        return $httpCode === 200;
    }

    /**
     * Mengirim alert sistem
     */
    public function sendAlert(string $type, string $message, bool $includeReferrer = true): bool
    {
        $agent = \Config\Services::userAgent();
        $request = \Config\Services::request();

        $clientInfo = [
            'browser'  => $agent->getBrowser() . ' ' . $agent->getVersion(),
            'os'       => $agent->getPlatform(),
            'ip'       => $request->getIPAddress(),
            'device'   => $agent->isMobile() ? '📱 Mobile' : '💻 Desktop',
            'url'      => current_url(),
            'referrer' => $includeReferrer ? ($agent->getReferrer() ?: 'Direct/Bookmark') : 'N/A'
        ];

        $iconMap = [
            'success' => '✅',
            'error'   => '🚨',
            'warning' => '⚠️',
            'info'    => 'ℹ️'
        ];
        $icon = $iconMap[strtolower($type)] ?? '📌';

        $text = "{$icon} <b>#" . strtoupper($type) . " ALERT</b>
"
               . "🕒 <b>Waktu:</b> " . date('Y-m-d H:i:s') . "
"
               . "📝 <b>Pesan:</b> {$message}

"
               . "🌐 <b>Browser:</b> {$clientInfo['browser']}
"
               . "🖥️ <b>OS:</b> {$clientInfo['os']}
"
               . "{$clientInfo['device']}
"
               . "🔗 <b>URL Saat Ini:</b> {$clientInfo['url']}
"
               . "↩️ <b>Referrer:</b> {$clientInfo['referrer']}
"
               . "🛡️ <b>IP:</b> {$clientInfo['ip']}";

        return $this->sendMessage($text);
    }
}
