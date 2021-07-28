<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_product_sold extends Model
{
    protected $table = 'product_sold';
    protected $primaryKey = 'id_sold';
    protected $useTimestamps = true;
    protected $allowedFields = ['product_id','seller_id','qty','note'];

    public function saveProductSold($data){
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
 
}