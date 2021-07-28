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
            // $query = $this->db->table($this->table)->select('* , '.$this->table.'.name as product_name ,'.$this->table.'.created_at as product_created_at  ')
            //             ->join('category_product', 'category_product.id_category='.$this->table.'.id_category')
            //             ->Where(['id_product' => $id])->get()->getRowArray();
            return $this->where(['id_product' => $id])->first();
            // return $query;
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
    public function search($keyword)
    {
        $query = $this->table($this->table)->like('name', $keyword);
        return $query;
    }
    public function getProducts($id = false)
    {
        if($id === false){
            return $this->db->table($this->table)->select('* , '.$this->table.'.name as product_name ,'.$this->table.'.created_at as product_created_at  ')->orderBy(''.$this->table.'.created_at','desc')
            ->join('category_product', 'category_product.id_category='.$this->table.'.id_category')
            ->get()->getResultArray();
        }else{
            $query = $this->db->table($this->table)->select('* , '.$this->table.'.name as product_name ,'.$this->table.'.created_at as product_created_at  ')
                        ->join('category_product', 'category_product.id_category='.$this->table.'.id_category')
                        ->Where(['id_product' => $id])->get()->getRowArray();
            
            return $query;
        }
    }
}