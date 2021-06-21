<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_seller extends Model
{
    protected $table = 'seller';
    protected $primaryKey = 'id_seller';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_seller','id_admin','name','email','phone','password','gender','address','img'];

    public function getSeller($id = false)
    {
        if($id === false){
            return $this->orderBy('created_at','desc')->findAll();
        }else{
            return $this->where(['id_seller' => $id])->first();
        }   
    }
    public function saveSeller($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
    public function updateSeller($data, $id){
        $query = $this->db->table($this->table)->update($data,['id_seller' => $id]);
        return $query;
    }
}