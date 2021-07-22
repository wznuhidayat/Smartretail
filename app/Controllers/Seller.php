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
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('seller/dashboard', $data);
    }
    public function productList()
    {
        $pager = \Config\Services::pager();
        $data = [
            'title' => 'list product',
            'product' => $this->M_product->paginate(12,'product'),
            'pager' => $this->M_product->pager
        ];
        // dd($data);
        return view('seller/product/product_list',$data);
    }
}