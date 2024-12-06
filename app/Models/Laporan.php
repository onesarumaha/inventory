<?php

namespace App\Models;

use CodeIgniter\Model;

class Laporan extends Model
{
    protected $table            = 'laporan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['parant_id', 'date', 'product_id', 'quantity', 'type', 'from', 'user_id', 'omset'];

    public function getSalesByUser()
    {
        return $this->select('users.username, SUM(laporan.omset) as total_sales')
            ->join('users', 'users.id = laporan.user_id')
            ->groupBy('laporan.user_id')
            ->orderBy('total_sales', 'DESC')
            ->findAll();
    }
  
}
