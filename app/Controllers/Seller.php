<?php

namespace App\Controllers;
use App\Models\M_admin;
use App\Models\M_seller;
use App\Models\M_product;
use App\Models\M_product_img;
use App\Models\M_cat_product;


class Seller extends BaseController
{
    public function __construct()
    {
        $this->M_product = new M_product();
        $this->M_product_img = new M_product_img();
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
        }elseif($url == 'sold' && $id != null){
            $data = [
                'title' => 'Product Sold'
            ];
            return view('seller/product/product_sold', $data);
        }
        $pager = \Config\Services::pager();

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $product = $this->M_product->search($keyword);
        }else{
            $product = $this->M_product->join('product_img','product_img.product_id=product.id_product','left');
        }

        $data = [
            'title' => 'list product',
            'product' => $product->paginate(12,'product'),
            'pager' => $this->M_product->pager
        ];
        dd($this->M_product->join('product_img','product_img.product_id=product.id_product','left')->paginate(12,'product'));
        return view('/seller/product/product_list',$data);
    }
    public function dataexample()
    {
        dd($this->request->getPost('keyword'));
    }
}