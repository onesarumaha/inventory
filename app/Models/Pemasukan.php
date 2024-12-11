<?php

namespace App\Models;

use CodeIgniter\Model;

class Pemasukan extends Model
{
    protected $table            = 'pengadaan_barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'quantity', 'upload', 'price', 'supplier_id', 'user_id', 'date', 'status', 'quantity_real', 'ket'];

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

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function supplier() 
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function user() 
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    public function getNotificationsWithRelations()
    {
        $this->select('pengadaan_barang.*, pengadaan_barang.id, users.username, product.name');
        $this->join('users', 'users.id = pengadaan_barang.user_id');
        $this->join('product', 'product.id = pengadaan_barang.product_id');
        $this->where('pengadaan_barang.status <', 3); 
        return $this->findAll();
    }
}
