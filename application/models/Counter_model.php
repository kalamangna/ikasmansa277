<?php
class Counter_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();

    }

    // Log kunjungan
    public function log_visit($data) {
        $this->db->insert('counter_logs', $data);
        return $this->db->insert_id();
    }

    // Update counter harian
    public function update_daily_counter($date, $is_unique = false) {
        // Cek apakah sudah ada record untuk tanggal ini
        $this->db->where('visit_date', $date);
        $query = $this->db->get('counter_daily');
        
        if ($query->num_rows() > 0) {
            // Update existing record
            $this->db->set('total_visits', 'total_visits+1', FALSE);
            if ($is_unique) {
                $this->db->set('unique_visits', 'unique_visits+1', FALSE);
            }
            $this->db->where('visit_date', $date);
            $this->db->update('counter_daily');
        } else {
            // Insert new record
            $data = array(
                'visit_date' => $date,
                'total_visits' => 1,
                'unique_visits' => $is_unique ? 1 : 0
            );
            $this->db->insert('counter_daily', $data);
        }
    }

    // Cek apakah IP sudah mengakses hari ini
    public function is_unique_visit_today($ip) {
        $today = date('Y-m-d');
        $this->db->where('ip_address', $ip);
        $this->db->where('DATE(created_at)', $today);
        $query = $this->db->get('counter_logs');
        return ($query->num_rows() == 0);
    }

    // Get total visits
    public function get_total_visits() {
        $this->db->select_sum('total_visits');
        $query = $this->db->get('counter_daily');
        return $query->row()->total_visits;
    }

    // Get unique visits
    public function get_unique_visits() {
        $this->db->select_sum('unique_visits');
        $query = $this->db->get('counter_daily');
        return $query->row()->unique_visits;
    }

    // Get daily stats
    public function get_daily_stats($limit = 30) {
        $this->db->order_by('visit_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('counter_daily')->result();
    }

    // Get recent visits
    public function get_recent_visits($limit = 10) {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('counter_logs')->result();
    }


// Get available years with data
public function get_available_years() {
    $this->db->select('YEAR(visit_date) as year');
    $this->db->from('counter_daily');
    $this->db->group_by('YEAR(visit_date)');
    $this->db->order_by('year', 'DESC');
    return $this->db->get()->result();
}

// Get monthly stats for a year
public function get_monthly_stats($year) {
    $this->db->select('MONTH(visit_date) as month, SUM(total_visits) as total, SUM(unique_visits) as `unique`');
    $this->db->from('counter_daily');
    $this->db->where('YEAR(visit_date)', $year);
    $this->db->group_by('MONTH(visit_date)');
    $this->db->order_by('month', 'ASC');
    return $this->db->get()->result();
}

// Get OS stats
public function get_os_stats($year = null) {
    $this->db->select("
        CASE 
            WHEN user_agent LIKE '%Windows%' THEN 'Windows'
            WHEN user_agent LIKE '%Macintosh%' THEN 'Mac OS'
            WHEN user_agent LIKE '%Linux%' THEN 'Linux'
            WHEN user_agent LIKE '%Android%' THEN 'Android'
            WHEN user_agent LIKE '%iPhone%' OR user_agent LIKE '%iPad%' THEN 'iOS'
            ELSE 'Lainnya'
        END as os,
        COUNT(*) as count
    ", false); // false agar tidak di-escape oleh CI
    $this->db->from('counter_logs');
    
    if ($year) {
        $this->db->where('YEAR(created_at)', $year);
    }
    
    $this->db->group_by('os');
    $this->db->order_by('count', 'DESC');
    return $this->db->get()->result();
}

// Get browser stats
public function get_browser_stats($year = null) {
    $this->db->select("
        CASE 
            WHEN user_agent LIKE '%Chrome%' AND user_agent NOT LIKE '%Edge%' THEN 'Chrome'
            WHEN user_agent LIKE '%Firefox%' THEN 'Firefox'
            WHEN user_agent LIKE '%Safari%' AND user_agent NOT LIKE '%Chrome%' THEN 'Safari'
            WHEN user_agent LIKE '%Edge%' THEN 'Edge'
            WHEN user_agent LIKE '%Opera%' OR user_agent LIKE '%OPR%' THEN 'Opera'
            WHEN user_agent LIKE '%MSIE%' OR user_agent LIKE '%Trident%' THEN 'Internet Explorer'
            ELSE 'Lainnya'
        END as browser,
        COUNT(*) as count
    ");
    $this->db->from('counter_logs');
    
    if ($year) {
        $this->db->where('YEAR(created_at)', $year);
    }
    
    $this->db->group_by('browser');
    $this->db->order_by('count', 'DESC');
    return $this->db->get()->result();
}    
public function get_top_pages($year, $limit = 10) {
    $this->db->select('page_visited, COUNT(*) as visit_count');
    $this->db->from('counter_logs');
    $this->db->where('YEAR(created_at)', $year);
    $this->db->group_by('page_visited');
    $this->db->order_by('visit_count', 'DESC');
    $this->db->limit($limit);
    return $this->db->get()->result();
}
// Fungsi untuk mendapatkan warna chart berdasarkan label
public function get_chart_color($label) {
    $color_map = array(
        'Windows' => '#4e73df',
        'Mac OS' => '#1cc88a',
        'Linux' => '#36b9cc',
        'Android' => '#f6c23e',
        'iOS' => '#e74a3b',
        'Chrome' => '#4285F4',
        'Firefox' => '#FF9500',
        'Safari' => '#1CD1D1',
        'Edge' => '#0078D7',
        'Opera' => '#FF1B2D',
        'Internet Explorer' => '#00A2ED',
        'Lainnya' => '#858796'
    );
    
    return isset($color_map[$label]) ? $color_map[$label] : '#5a5c69';
}




    public function track_visit() {
        // Skip tracking if accessing counter dashboard
        $current_uri = $this->input->server('REQUEST_URI');
        $ip = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        $page_visited = $current_uri;
        
        $is_unique_today = $this->Counter_model->is_unique_visit_today($ip);
        if ($this->session->userdata('nama')) {
            $user_name=$this->session->userdata('nama');
        } else {
            $user_name="";
        }
        $data = array(
            'ip_address' => $ip,
            'user_agent' => $user_agent,
            'page_visited' => $page_visited,
            'user_name' => $user_name
        );
        $this->Counter_model->log_visit($data);
        $this->Counter_model->update_daily_counter(date('Y-m-d'), $is_unique_today);
    }

}