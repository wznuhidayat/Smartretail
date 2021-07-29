<?php

namespace App\Controllers;
use App\Models\M_admin;
use App\Models\M_seller;
use App\Models\M_product;
use App\Models\M_product_img;
use App\Models\M_product_sold;
use App\Models\M_cat_product;


class Seller extends BaseController
{
    public function __construct()
    {
        $this->M_product = new M_product();
        $this->M_seller = new M_seller();
        $this->M_product_img = new M_product_img();
        $this->M_product_sold = new M_product_sold();
        helper('url', 'form', 'html');
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('seller/dashboard', $data);
    }
    public function productList($url = 'index', $id = null)
    {
        if ($url == 'detail' && $id != null){
            $query_product = $this->M_product->getProducts($id);
            $query_img = $this->M_product_img->getImgWhereId($id);
            $data = [
                'title' => 'Detail Product',
                'product' => $query_product,
                'img' => $query_img
            ];
            return view('admin/product/detail_product', $data);
        }elseif($url == 'sold'){
            $data = [
                'title' => 'Product Sold'
            ];
            return view('seller/product/product_sold', $data);
        }elseif($url == 'save'){
            
            $str = "";
            $characters = array_merge(range('0', '6'));
            $max = count($characters) - 1;
            for ($i = 0; $i < 8; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            $data = array(
                'id_sold'        => $str,
                'product_id'       => $this->request->getPost('id_product'),
                'seller_id' => $this->request->getPost('id_seller'),
                'qty' => $this->request->getPost('qty'),
                'note' => $this->request->getPost('note'),
                'created_at'  => date('Y/m/d h:i:s'),
                'updated_at'  => date('Y/m/d h:i:s'),
            );
            // dd($data);
            $this->M_product_sold->saveProductSold($data);
            return redirect()->to('/seller/productlist');
        }
        $pager = \Config\Services::pager();

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $product = $this->M_product->search($keyword);
        }else{
            $product = $this->M_product;
        }

        $data = [
            'title' => 'list product',
            'product' => $product->paginate(12,'product'),
            'pager' => $this->M_product->pager,
            'img' => $this->M_product_img->findAll()
        ];
        // dd($data);
        return view('/seller/product/product_list',$data);
    }
    public function sold($url = 'index', $id = null)
    {
        if($url == 'delete' && $id != null){
            $this->M_product_sold->delete($id);
            return redirect()->to('/seller/sold');
        }
        $data = [
            'title' => 'Products sold',
            'sold' => $this->M_product_sold->getProductsSold(session()->get('id_seller'))
        ];
        // dd($data);
        return view('/seller/product/products_sold',$data);
    }
}