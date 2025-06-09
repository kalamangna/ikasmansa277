<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_model extends CI_Model {

    protected $bot_token;
    protected $chat_id;

    public function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->helper('url');
        
        // Konfigurasi Telegram (bisa juga disimpan di database/config)
        $this->bot_token = TELEGRAM_BOT_TOKEN; // Ganti dengan token bot Anda
        $this->chat_id = TELEGRAM_CHAT_ID; // Ganti dengan chat ID tujuan
    }

    /**
     * Mengirim pesan ke Telegram
     */
    public function send_message($text, $parse_mode = 'HTML') {
        $data = [
            'chat_id' => $this->chat_id,
            'text' => $text,
            'parse_mode' => $parse_mode
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.telegram.org/bot{$this->bot_token}/sendMessage",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5
        ]);
        
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
         
        // return json_decode($result, true);
        return $http_code == 200 ? true : false;

    }

    /**
     * Mengirim alert sistem
     */
public function send_alert($type, $message, $include_referrer = true) {
        $client_info = [
            'browser' => $this->agent->browser().' '.$this->agent->version(),
            'os' => $this->agent->platform(),
            'ip' => $this->input->ip_address(),
            'device' => $this->agent->is_mobile() ? '📱 Mobile' : '💻 Desktop',
            'url' => current_url(),
            'referrer' => $include_referrer ? ($this->agent->referrer() ?? 'Direct/Bookmark') : 'N/A'
        ];

        $icon = [
            'success' => '✅',
            'error' => '🚨',
            'warning' => '⚠️',
            'info' => 'ℹ️'
        ][strtolower($type)] ?? '📌';

        $text = "{$icon} <b>".strtoupper($type)." ALERT</b>\n"
               ."🕒 <b>Waktu:</b> ".date('Y-m-d H:i:s')."\n"
               ."📝 <b>Pesan:</b> {$message}\n\n"
               ."🌐 <b>Browser:</b> {$client_info['browser']}\n"
               ."🖥️ <b>OS:</b> {$client_info['os']}\n"
               ."{$client_info['device']}\n"
               ."🔗 <b>URL Saat Ini:</b> {$client_info['url']}\n"
               ."↩️ <b>Referrer:</b> {$client_info['referrer']}\n"
               ."🛡️ <b>IP:</b> {$client_info['ip']}";

        return $this->send_message($text);
    }
    
}