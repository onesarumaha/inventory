<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaksi extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_transaksi', 'date', 'total_price', 'customer_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
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

    public function getCustomer()
    {
        return $this->join('customer', 'customer.id = transaksi.customer_id', 'left')
                    ->orderBy('transaksi.id', 'DESC')
                    ->findAll();
    }


    public function getWithProduct($id = null)
    {
        $builder = $this->select('transaksi.*, customer.name AS nama_customer, product.name AS nama_product')
                        ->join('customer', 'customer.id = transaksi.customer_id', 'left')
                        ->join('transaksi_item', 'transaksi_item.transaksi_id = transaksi.id', 'left')
                        ->join('product', 'product.id = transaksi_item.product_id', 'left')
                        ->orderBy('transaksi.id', 'DESC');

        if ($id !== null) {
            $builder->where('transaksi.id', $id);
            return $builder->first(); 
        }

        return $builder->findAll(); 
    }

}
