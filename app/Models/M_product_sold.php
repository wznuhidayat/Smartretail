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
        $query = $this->db->table($this->table)->select('*,product.name as product_name, ' . $this->table . '.qty as sold_qty')->orderBy('' . $this->table . '.created_at', 'desc')
            ->join('product', 'product.id_product=' . $this->table . '.product_id')
            ->join('seller', 'seller.id_seller=' . $this->table . '.seller_id')
            ->Where(['seller_id' => $id])->get()->getResultArray();
        // $query = $this->where(['seller_id' => $id]);
        return $query;
    }
    public function getMonthly()
    {
        $query = $this->db->query('
        SELECT product_id, name,
        
        (select sum(qty) FROM product_sold WHERE month(created_at) = 1 and product_id = sold.product_id) as jan,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 2 and product_id = sold.product_id) as feb,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 3 and product_id = sold.product_id) as mar,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 4 and product_id = sold.product_id) as apr,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 5 and product_id = sold.product_id) as mei,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 6 and product_id = sold.product_id) as jun
        
        
        FROM product_sold as sold 
        
        JOIN product ON sold.product_id=product.id_product

        GROUP BY product_id')->getResultArray();


        return $query;
    }
    public function getSalesData($date_start, $date_end)
    {
        $query = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month, product_id,sum(qty) as qty
            FROM product_sold 
            WHERE DATE_FORMAT(created_at, '%Y-%m') >= '$date_start' AND
            DATE_FORMAT(created_at,'%Y-%m') <= '$date_end'
            GROUP BY month, product_id
            ORDER BY month ASC
            ")->getResultArray();

        return $query;
    }
    public function getAllProductSales($date_start, $date_end)
    {
        $query = $this->db->query("
            SELECT  product_id,sum(product_sold.qty) as qty,name
            FROM product_sold 
            JOIN product ON product_sold.product_id=product.id_product
            WHERE DATE_FORMAT(product_sold.created_at, '%Y-%m') >= '$date_start' AND
            DATE_FORMAT(product_sold.created_at,'%Y-%m') <= '$date_end'
            GROUP BY product_id
            ")->getResultArray();

        return $query;
    }
    public function getMonthlyAnn()
    {
        $query = $this->db->query('
        SELECT product_id, 
        
        (select sum(qty) FROM product_sold WHERE month(created_at) = 1 and product_id = sold.product_id) as jan,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 2 and product_id = sold.product_id) as feb,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 3 and product_id = sold.product_id) as mar,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 4 and product_id = sold.product_id) as apr,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 5 and product_id = sold.product_id) as mei,
        (select sum(qty) FROM product_sold WHERE month(created_at) = 6 and product_id = sold.product_id) as jun
        
        
        FROM product_sold as sold 
        
     

        GROUP BY product_id')->getResultArray();


        return $query;
    }
    public function getTarget()
    {
        $query = $this->db->query('
        SELECT product_id, 
        
        
        (select sum(qty) FROM product_sold WHERE month(created_at) = 7 and product_id = sold.product_id) as jul
        
        
        FROM product_sold as sold 
        
     

        GROUP BY product_id')->getResultArray();


        return $query;
    }
    public function getTargetById($id)
    {
        $query = $this->db->query('
        SELECT product_id, 
        
        
        (select sum(qty) FROM product_sold WHERE month(created_at) = 7 and product_id = sold.product_id) as jul
        
        
        FROM product_sold as sold 
        
     
        WHERE product_id = ' . $id . '
        GROUP BY product_id
        ')->getResultArray();


        return $query;
    }
    public function countProductSale()
    {
        $query = $this->db->table($this->table)->countAll();
        return $query;
    }
}