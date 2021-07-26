<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_product_img extends Model
{
    protected $table = 'product_img';
    protected $primaryKey = 'id_product_image';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_product_img','product_id','img','create_at','update_at'];

   
    public function getImgWhereId($id)
    {
        return $this->where(['product_id' => $id])->findAll();
    }
    public function saveImg($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
}