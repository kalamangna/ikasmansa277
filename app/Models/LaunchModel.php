<?php

namespace App\Models;

use CodeIgniter\Model;

class LaunchModel extends Model
{
    protected $table            = 'launch_settings';
    protected $returnType       = 'object';
    protected $allowedFields    = ['start_time'];

    public function getLaunchData()
    {
        return $this->first();
    }
    
    public function setLaunchData(string $startTime)
    {
        $data = ['start_time' => $startTime];
        
        if ($this->countAllResults() > 0) {
            return $this->builder()->update($data);
        }
        
        return $this->insert($data);
    }
    
    public function resetLaunch()
    {
        return $this->builder()->emptyTable($this->table);
    }
}
