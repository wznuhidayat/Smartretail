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

    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('seller/dashboard', $data);
    }
}