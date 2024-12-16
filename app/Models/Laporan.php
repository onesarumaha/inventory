<?php

namespace App\Models;

use CodeIgniter\Model;

class Laporan extends Model
{
    protected $table            = 'laporan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
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

    public function getTopProducts($bulan, $tahun)
    {
        return $this->select('product.name as product_name, SUM(laporan.quantity) as total_sold')
                ->join('product', 'product.id = laporan.product_id')
                ->where('MONTH(laporan.date)', $bulan)
                ->where('YEAR(laporan.date)', $tahun)  
                ->where('type', 'out')  
                ->where('laporan.deleted_at', null)  
                ->groupBy('laporan.product_id')
                ->orderBy('total_sold', 'DESC')
                ->limit(3)
                ->findAll();
    }

    public function getTotalOmsetHariIni()
    {
        $tanggalHariIni = date('Y-m-d'); 
        return $this->selectSum('omset')
                    ->where('DATE(date)', $tanggalHariIni)
                    ->where('type', 'out') 
                    ->where('deleted_at', null)  
                    ->get()
                    ->getRow()
                    ->omset;
    }

    public function getTotalOmsetBulanan()
    {
        $bulanIni = date('Y-m');
        return $this->selectSum('omset')
                    ->where('DATE_FORMAT(date, "%Y-%m")', $bulanIni)
                    ->where('type', 'out')  
                    ->where('deleted_at', null)  
                    ->get()
                    ->getRow()
                    ->omset;
    }

    public function getTotalOmsetTahunan()
    {
        $tahunIni = date('Y'); 
        return $this->selectSum('omset')
                    ->where('DATE_FORMAT(date, "%Y")', $tahunIni)
                    ->where('type', 'out')  
                    ->where('deleted_at', null)  
                    ->get()
                    ->getRow()
                    ->omset;
    }
  
}
