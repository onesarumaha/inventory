<?php

namespace App\Models;

use CodeIgniter\Model;

class Omset extends Model
{
    protected $table            = 'laporan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

   public function getProduct()
   {
        return $this->join('product', 'product.id = laporan.product_id', 'left')
            ->where('laporan.type', 'out') 
            ->orderBy('laporan.id', 'DESC')
            ->findAll();
   }

   public function getProducts()
   {
       return $this->select('laporan.*, product.name as product_name')
                   ->join('product', 'product.id = laporan.product_id')
                   ->findAll();
   }

   public function getProductByPetugas($petugas_id)
   {
       return $this->select('laporan.*, product.name AS name')
                   ->join('product', 'product.id = laporan.product_id', 'left')
                   ->where('laporan.user_id', $petugas_id,)
                   ->where( 'laporan.type', 'out')
                   ->orderBy('laporan.id', 'DESC')
                   ->findAll();
   }

   public function getPengadaanPetugas($petugas_id)
   {
       return $this->select('laporan.*, product.name AS name')
                   ->join('product', 'product.id = laporan.product_id', 'left')
                   ->where('laporan.user_id', $petugas_id)
                   ->where('laporan.type', 'in')
                   ->orderBy('laporan.id', 'DESC')
                   ->findAll();
   }

   public function getLaporanPetugas()
   {
        return $this->join('product', 'product.id = laporan.product_id', 'left')
            ->where('laporan.type', 'in') 
            ->orderBy('laporan.id', 'DESC')
            ->findAll();
   }
   
}
