<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Product_Datatable extends Model
{
    protected $table = 'product';
    protected $column_order = [null,'id_product', 'name', 'id_category ','qty','price',null];
    protected $column_search = ['name', 'id_product'];
    protected $order = ['created_at' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);

    }

    
}