<?php

namespace App\Models;

use CodeIgniter\Model;

class CounterModel extends Model
{
    protected $table            = 'counter_logs';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['ip_address', 'user_agent', 'page_visited', 'user_name', 'created_at'];

    public function logVisit(array $data)
    {
        return $this->insert($data);
    }

    public function updateDailyCounter(string $date, bool $isUnique = false)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('counter_daily');
        
        $row = $builder->where('visit_date', $date)->get()->getRow();
        
        if ($row) {
            $builder->set('total_visits', 'total_visits+1', false);
            if ($isUnique) {
                $builder->set('unique_visits', 'unique_visits+1', false);
            }
            return $builder->where('visit_date', $date)->update();
        } else {
            $data = [
                'visit_date'    => $date,
                'total_visits'  => 1,
                'unique_visits' => $isUnique ? 1 : 0
            ];
            return $builder->insert($data);
        }
    }

    public function isUniqueVisitToday(string $ip): bool
    {
        $today = date('Y-m-d');
        return $this->where('ip_address', $ip)
                    ->where('DATE(created_at)', $today)
                    ->countAllResults() === 0;
    }

    public function getTotalVisits(): int
    {
        return (int) $this->db->table('counter_daily')
                             ->selectSum('total_visits')
                             ->get()
                             ->getRow()->total_visits ?? 0;
    }

    public function getUniqueVisits(): int
    {
        return (int) $this->db->table('counter_daily')
                             ->selectSum('unique_visits')
                             ->get()
                             ->getRow()->unique_visits ?? 0;
    }

    public function getDailyStats(int $limit = 30): array
    {
        return $this->db->table('counter_daily')
                        ->orderBy('visit_date', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->getResult();
    }

    public function getRecentVisits(int $limit = 10): array
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    public function getAvailableYears(): array
    {
        return $this->db->table('counter_daily')
                        ->select('YEAR(visit_date) as year')
                        ->groupBy('YEAR(visit_date)')
                        ->orderBy('year', 'DESC')
                        ->get()
                        ->getResult();
    }

    public function getMonthlyStats(int $year): array
    {
        return $this->db->table('counter_daily')
                        ->select('MONTH(visit_date) as month, SUM(total_visits) as total, SUM(unique_visits) as `unique`')
                        ->where('YEAR(visit_date)', $year)
                        ->groupBy('MONTH(visit_date)')
                        ->orderBy('month', 'ASC')
                        ->get()
                        ->getResult();
    }

    public function getOsStats(?int $year = null): array
    {
        $builder = $this->builder()
            ->select("
                CASE 
                    WHEN user_agent LIKE '%Windows%' THEN 'Windows'
                    WHEN user_agent LIKE '%Macintosh%' THEN 'Mac OS'
                    WHEN user_agent LIKE '%Linux%' THEN 'Linux'
                    WHEN user_agent LIKE '%Android%' THEN 'Android'
                    WHEN user_agent LIKE '%iPhone%' OR user_agent LIKE '%iPad%' THEN 'iOS'
                    ELSE 'Lainnya'
                END as os,
                COUNT(*) as count
            ", false);
        
        if ($year) {
            $builder->where('YEAR(created_at)', $year);
        }
        
        return $builder->groupBy('os')
                       ->orderBy('count', 'DESC')
                       ->get()
                       ->getResult();
    }

    public function getBrowserStats(?int $year = null): array
    {
        $builder = $this->builder()
            ->select("
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
            ", false);
        
        if ($year) {
            $builder->where('YEAR(created_at)', $year);
        }
        
        return $builder->groupBy('browser')
                       ->orderBy('count', 'DESC')
                       ->get()
                       ->getResult();
    }

    public function getTopPages(int $year, int $limit = 10): array
    {
        return $this->select('page_visited, COUNT(*) as visit_count')
                    ->where('YEAR(created_at)', $year)
                    ->groupBy('page_visited')
                    ->orderBy('visit_count', 'DESC')
                    ->findAll($limit);
    }

    public function getChartColor(string $label): string
    {
        $colorMap = [
            'Windows'           => '#4e73df',
            'Mac OS'            => '#1cc88a',
            'Linux'             => '#36b9cc',
            'Android'           => '#f6c23e',
            'iOS'               => '#e74a3b',
            'Chrome'            => '#4285F4',
            'Firefox'           => '#FF9500',
            'Safari'            => '#1CD1D1',
            'Edge'              => '#0078D7',
            'Opera'             => '#FF1B2D',
            'Internet Explorer' => '#00A2ED',
            'Lainnya'           => '#858796'
        ];
        
        return $colorMap[$label] ?? '#5a5c69';
    }
}
