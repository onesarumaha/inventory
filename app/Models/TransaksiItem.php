<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiItem extends Model
{
    protected $table            = 'transaksi_item';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['transaksi_id', 'product_id', 'quantity', 'price', 'total', 'user_id', 'date'];


}
