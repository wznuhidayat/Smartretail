<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_cat_product extends Model
{
    protected $table = 'category_product';
    protected $primaryKey = 'id_category';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_category','name'];

    public function getCatProduct($id = false)
    {
        if($id === false){
            return $this->orderBy('created_at','desc')->findAll();
        }else{
            return $this->where(['id_category' => $id])->first();
        }   
    }
    public function saveCatProduct($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
    public function updateCatProduct($data, $id){
        $query = $this->db->table($this->table)->update($data,['id_category' => $id]);
        return $query;
    }
}