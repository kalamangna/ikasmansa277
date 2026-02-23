<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CounterModel;

class Counter extends BaseController
{
    protected $counterModel;

    public function __construct()
    {
        $this->counterModel = new CounterModel();
    }

    public function index(): string
    {
        $selectedYear = $this->request->getGet('tahun') ?? date('Y');
        
        $data = [
            'hidden_counter'  => true,
            'total_visits'    => $this->counterModel->getTotalVisits(),
            'unique_visits'   => $this->counterModel->getUniqueVisits(),
            'daily_stats'     => $this->counterModel->getDailyStats(),
            'recent_visits'   => $this->counterModel->getRecentVisits(),
            'available_years' => $this->counterModel->getAvailableYears(),
            'selected_year'   => $selectedYear,
            'monthly_stats'   => $this->counterModel->getMonthlyStats($selectedYear),
            'os_stats'        => $this->counterModel->getOsStats($selectedYear),
            'browser_stats'   => $this->counterModel->getBrowserStats($selectedYear),
            'top_pages'       => $this->counterModel->getTopPages($selectedYear)
        ];
        
        return $this->render('counter/dashboard', $data);
    }

    public function track_visit()
    {
        $currentUri  = $this->request->getServer('REQUEST_URI');
        $ip          = $this->request->getIPAddress();
        $userAgent   = $this->request->getUserAgent()->getAgentString();
        $pageVisited = $currentUri;
        
        $isUniqueToday = $this->counterModel->isUniqueVisitToday($ip);
        
        $data = [
            'ip_address'   => $ip,
            'user_agent'   => $userAgent,
            'page_visited' => $pageVisited
        ];
        
        $this->counterModel->logVisit($data);
        $this->counterModel->updateDailyCounter(date('Y-m-d'), $isUniqueToday);
        
        return $this->response->setBody('OK');
    }
}
