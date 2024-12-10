<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiItem extends Model
{
    protected $table            = 'transaksi_item';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['transaksi_id', 'product_id', 'quantity', 'price', 'total', 'user_id', 'date'];

    public function getItemsWithProduct($transaksiId)
    {
        return $this->select('transaksi_item.*, product.name AS nama_product')
                    ->join('product', 'product.id = transaksi_item.product_id', 'left')
                    ->where('transaksi_item.transaksi_id', $transaksiId)
                    ->findAll();
    }
    
}
