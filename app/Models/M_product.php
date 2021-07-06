<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_product','id_admin','name','qty','price','discount','description'];

    public function getProduct($id = false)
    {
        if($id === false){
            return $this->orderBy('created_at','desc')->findAll();
        }else{
            return $this->where(['id_product' => $id])->first();
        }   
    }
    public function saveProduct($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
    public function updateProduct($data, $id){
        $query = $this->db->table($this->table)->update($data,['id_product' => $id]);
        return $query;
    }
}