<?php 
namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class M_product_test extends Model
{
    protected $table = 'product_test';
    protected $primaryKey = 'id_product_test';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_product_test','product_id','x1','x2','x3','x4','x5','x6'];
    protected $request;
    protected $db;
    protected $dt;
    public function getDataTest($id = false)
    {
        if($id === false){
            
            // return $this->orderBy('create_at')->findAll();
            return $this->orderBy('create_at')->select($this->table.'.*, product.name') 
            ->join('product', 'product.id_product='.$this->table.'.product_id')
            ->get()->getResultArray();
          
        }else{
            
            return $this->where(['id_product' => $id])->first();
        }   
    }

    public function saveProductTest($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
   
    

}