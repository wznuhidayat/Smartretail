<?php

namespace App\Models;

use CodeIgniter\Model;

class M_product_sold extends Model
{
    protected $table = 'product_sold';
    protected $primaryKey = 'id_sold';
    protected $useTimestamps = true;
    protected $allowedFields = ['product_id', 'seller_id', 'qty', 'note'];

    public function saveProductSold($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
    public function getProductsSold($id)
    {
        $query = $this->db->table($this->table)->select('*,product.name as product_name, '.$this->table.'.qty as sold_qty')->orderBy(''.$this->table.'.created_at','desc')
            ->join('product', 'product.id_product=' . $this->table . '.product_id')
            ->join('seller', 'seller.id_seller=' . $this->table . '.seller_id')
            ->Where(['seller_id' => $id])->get()->getResultArray();
        // $query = $this->where(['seller_id' => $id]);
        return $query;
    }
}
