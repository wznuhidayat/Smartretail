<?php

namespace App\Controllers;

use App\Models\M_admin;
use App\Models\M_seller;
use App\Models\M_product;
use App\Models\M_product_img;
use App\Models\M_cat_product;


class Main extends BaseController
{
    public function __construct()
    {
        $this->M_admin = new M_admin();
        $this->M_seller = new M_seller();
        $this->M_product = new M_product();
        $this->M_product_img = new M_product_img();
        $this->M_cat_product = new M_cat_product();
        helper('url', 'form', 'html');
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('admin/dashboard', $data);
    }
    public function admin($url = 'index', $id = null)
    {
        if ($url == 'create') {
            $data = [
                'title' => 'Add Admin',
                'validation' => \Config\Services::validation()
            ];
            return view('admin/administator/add_admin', $data);
        } elseif ($url == 'save') {
            if (!$this->validate([
                'name' => [
                    'rules' => 'required',

                ],
                'email' => [
                    'rules' => 'required|is_unique[admin.email]|valid_email',

                ],
                'password' => [
                    'rules' => 'required|min_length[8]',

                ],
                'passconf' => [
                    'rules' => 'required|matches[password]',

                ],
                'gender' => 'required',
                'image' => [
                    'rules' => 'max_size[image,1024]|mime_in[image,image/jpg,image/jpeg,image/png]'
                ]
            ])) {
                // return ;
                $validation = \Config\Services::validation();
                return redirect()->to('/main/admin/create')->withInput()->with('validation', $validation);
            }
            $fileImg = $this->request->getFile('image');
            if ($fileImg->getError() == 4) {
                $nameImg = 'default.png';
            } else {
                $nameImg = $fileImg->getRandomName();
                $fileImg->move('img/admin/', $nameImg);
            }
            $str = "";
            $characters = array_merge(range('0', '6'));
            $max = count($characters) - 1;
            for ($i = 0; $i < 8; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            $data = [
                'id_admin' => $str,
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'password' => md5($this->request->getPost('password')),
                'gender' => $this->request->getPost(('gender')),
                'img' => $nameImg,
                'created_at' => date('Y/m/d h:i:s'),

            ];
            $this->M_admin->saveAdmin($data);
            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('success', 'Data saved successfully');
            }
            return redirect()->to('/main/admin');
        } elseif ($url == 'edit' && $id != null) {
            $query_admin = $this->M_admin->getAdmin($id);
            $data = [
                'title' => 'Edit Admin',
                'admin' => $query_admin,
                'validation' => \Config\Services::validation(),
            ];
            return view('admin/administator/edit_admin', $data);
        } elseif ($url == 'update' && $id != null) {
            $query_admin = $this->M_admin->getAdmin($id);
            if ($this->request->getPost('email') == $query_admin['email']) {
                if (!$this->validate([
                    'name' => [
                        'rules' => 'required',

                    ],
                    'email' => [
                        'rules' => 'required|valid_email',

                    ],
                    'passconf' => [
                        'rules' => 'matches[password]',

                    ],
                    'gender' => 'required',

                    'image' => 'max_size[image,1024]|mime_in[image,image/jpg,image/jpeg,image/png]'
                ])) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('/main/admin/edit/' . $id)->withInput()->with('validation', $validation);
                }
            } elseif ($this->request->getPost('email') != $query_admin['email']) {
                if (!$this->validate([
                    'name' => [
                        'rules' => 'required',

                    ],
                    'email' => [
                        'rules' => 'required|is_unique[admin.email]|valid_email',

                    ],
                    'password' => [
                        'rules' => 'min_length[8]',

                    ],
                    'passconf' => [
                        'rules' => 'matches[password]',

                    ],
                    'gender' => 'required',

                    'image' => 'max_size[image,1024]|mime_in[image,image/jpg,image/jpeg,image/png]'
                ])) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('/main/admin/edit/' . $id)->withInput();
                }
            }
            if (empty($this->request->getPost('password'))) {
                $pass = $query_admin['password'];
            } else {
                $pass = md5($this->request->getPost('password'));
            }
            $fileImg = $this->request->getFile('image');
            if ($fileImg->getError() == 4) {
                $nameImg = $this->request->getVar('oldimg');
            } else {
                $nameImg = $fileImg->getRandomName();
                $fileImg->move('img/admin', $nameImg);
                if ($this->request->getVar('oldimg') != 'default.png') {
                    unlink('img/admin/' . $this->request->getVar('oldimg'));
                }
            }
            $data = array(
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'gender' => $this->request->getPost('gender'),
                'password' => $pass,
                'img' => $nameImg,
                'created_at' => $query_admin["created_at"],
            );
            $this->M_admin->updateAdmin($data, $this->request->getPost('id'));
            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('edited', 'Data has been changed');
            }
            return redirect()->to('/main/admin');
        } elseif ($url == 'delete' && $id != null) {
            $item = $this->M_admin->getAdmin($id);
            if ($item['img'] != 'default.png') {
                unlink('img/admin/' . $item['img']);
            }
            $this->M_admin->delete($id);

            return redirect()->to('/main/admin');
        }
        $data = [
            'title' => 'Admin',
            'admin' => $this->M_admin->getAdmin(),
        ];
        return view('admin/administator/admin_view', $data);
    }
    public function seller($url = 'index', $id = null)
    {
        if ($url == 'create') {
            $data = [
                'title' => 'Add Seller',
                'validation' => \Config\Services::validation()
            ];
            return view('admin/seller/add_seller', $data);
        } elseif ($url == 'save') {
            if (!$this->validate([
                'name' => [
                    'rules' => 'required',

                ],
                'email' => [
                    'rules' => 'required|is_unique[seller.email]|valid_email',

                ],
                'password' => [
                    'rules' => 'required|min_length[8]',

                ],
                'passconf' => [
                    'rules' => 'required|matches[password]',

                ],
                'gender' => 'required',
                'address' => 'required',
                'image' => [
                    'rules' => 'max_size[image,1024]|mime_in[image,image/jpg,image/jpeg,image/png]'
                ]
            ])) {
                // return ;
                $validation = \Config\Services::validation();
                return redirect()->to('/main/seller/create')->withInput()->with('validation', $validation);
            }
            $fileImg = $this->request->getFile('image');
            if ($fileImg->getError() == 4) {
                $nameImg = 'default.png';
            } else {
                $nameImg = $fileImg->getRandomName();
                $fileImg->move('img/seller/', $nameImg);
            }
            $str = "";
            $characters = array_merge(range('0', '6'));
            $max = count($characters) - 1;
            for ($i = 0; $i < 9; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            $data = [
                'id_seller' => $str,
                'id_admin' => session()->get('id_admin'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'password' => md5($this->request->getPost('password')),
                'gender' => $this->request->getPost(('gender')),
                'address' => $this->request->getPost(('address')),
                'img' => $nameImg,
                'created_at' => date('Y/m/d h:i:s'),

            ];
            $this->M_seller->saveSeller($data);
            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('success', 'data saved successfully');
            }

            return redirect()->to('/main/seller');
        } elseif ($url == 'edit' && $id != null) {
            $query_seller = $this->M_seller->getSeller($id);
            $data = [
                'title' => 'Edit Seller',
                'seller' => $query_seller,
                'validation' => \Config\Services::validation(),
            ];
            return view('admin/seller/edit_seller', $data);
        } elseif ($url == 'update' && $id != null) {
            $query_seller = $this->M_seller->getSeller($id);
            if ($this->request->getPost('email') == $query_seller['email']) {
                if (!$this->validate([
                    'name' => [
                        'rules' => 'required',

                    ],
                    'email' => [
                        'rules' => 'required|valid_email',

                    ],
                    'passconf' => [
                        'rules' => 'matches[password]',

                    ],
                    'gender' => 'required',
                    'address' => 'required',

                    'image' => 'max_size[image,1024]|mime_in[image,image/jpg,image/jpeg,image/png]'
                ])) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('/main/seller/edit/' . $id)->withInput()->with('validation', $validation);
                }
            } elseif ($this->request->getPost('email') != $query_seller['email']) {
                if (!$this->validate([
                    'name' => [
                        'rules' => 'required',

                    ],
                    'email' => [
                        'rules' => 'required|is_unique[admin.email]|valid_email',

                    ],
                    'password' => [
                        'rules' => 'min_length[8]',

                    ],
                    'passconf' => [
                        'rules' => 'matches[password]',

                    ],
                    'gender' => 'required',
                    'address' => 'required',

                    'image' => 'max_size[image,1024]|mime_in[image,image/jpg,image/jpeg,image/png]'
                ])) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('/main/seller/edit/' . $id)->withInput();
                }
            }
            if (empty($this->request->getPost('password'))) {
                $pass = $query_seller['password'];
            } else {
                $pass = md5($this->request->getPost('password'));
            }
            $fileImg = $this->request->getFile('image');
            if ($fileImg->getError() == 4) {
                $nameImg = $this->request->getVar('oldimg');
            } else {
                $nameImg = $fileImg->getRandomName();
                $fileImg->move('img/seller', $nameImg);
                if ($this->request->getVar('oldimg') != 'default.png') {
                    unlink('img/seller/' . $this->request->getVar('oldimg'));
                }
            }
            $data = array(
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'gender' => $this->request->getPost('gender'),
                'password' => $pass,
                'address' => $this->request->getPost('address'),
                'img' => $nameImg,
                'created_at' => $query_seller["created_at"],
            );
            $this->M_seller->updateSeller($data, $this->request->getPost('id'));
            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('edited', 'Data has been changed');
            }
            return redirect()->to('/main/seller');
        } elseif ($url == 'delete' && $id != null) {
            $item = $this->M_seller->getSeller($id);
            if ($item['img'] != 'default.png') {
                unlink('img/seller/' . $item['img']);
            }
            $this->M_seller->delete($id);
            return redirect()->to('/main/seller');
        }
        $data = [
            'title' => 'Seller',
            'seller' => $this->M_seller->getSeller()
        ];
        return view('admin/seller/seller_view', $data);
    }
    //product
    public function product($url = 'index', $id = null)
    {
        if ($url == 'create') {
            $data = [
                'title' => 'Add Product',
                'validation' => \Config\Services::validation()
            ];
            return view('admin/product/add_product', $data);
        } elseif ($url == 'save') {
            if (!$this->validate([
                'name' => 'required',
                'qty' => 'numeric',
                'price' => 'numeric',
                'discount' => 'numeric',

            ])) {
                // return ;
                $validation = \Config\Services::validation();
                return redirect()->to('/main/product/create')->withInput()->with('validation', $validation);
            }
            $str = "";
            $characters = array_merge(range('0', '6'));
            $max = count($characters) - 1;
            for ($i = 0; $i < 11; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            // $fileImg = $this->request->getFile('image');
            // if ($fileImg->getError() == 4) {
            //     $nameImg = 'default.png';
            // } else {
            //     $nameImg = $fileImg->getRandomName();
            //     $fileImg->move('img/admin/', $nameImg);
            // }
                
          
            $data = [
                'id_product' => $str,
                'id_admin' => session()->get('id_admin'),
                'name' => $this->request->getPost('name'),
                'qty' => $this->request->getPost('qty'),
                'price' => $this->request->getPost('price'),
                'discount' => $this->request->getPost('discount'),
                'description' => $this->request->getPost('description'),
                'created_at' => date('Y/m/d h:i:s'),
                'updated_at' => date('Y/m/d h:i:s'),

            ];
            $this->M_product->saveProduct($data);
            $files = $this->request->getFileMultiple('images');
            if ($this->request->getFileMultiple('images')) {

                foreach ($this->request->getFileMultiple('images') as $file) {
                    $nameImg = date('ymd').'-'.substr(md5(rand()),0,10);
                    $file->move('img/product', $nameImg);

                    $data = [
                        'id_product_img' =>  rand(),
                        'id_product'  => $str,
                        'img'  =>  $nameImg,
                        'created_at'  => date('Y/m/d h:i:s'),
                        'updated_at'  => date('Y/m/d h:i:s'),
                    ];
                    $this->M_product_img->save($data);
                }
            }

            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('success', 'Data saved successfully');
            }
            return redirect()->to('/main/product');
        } elseif ($url == 'edit' && $id != null) {
            $query_product = $this->M_product->getProduct($id);
            $data = [
                'title' => 'Edit Product',
                'product' => $query_product,
                'validation' => \Config\Services::validation(),
            ];
            return view('admin/product/edit_product', $data);
        } elseif ($url == 'update' && $id != null) {
            $query_product = $this->M_product->getProduct($id);
            if (!$this->validate([
                'name' => 'required',
                'qty' => 'numeric',
                'price' => 'numeric',
                'discount' => 'numeric',

            ])) {
                $validation = \Config\Services::validation();
                return redirect()->to('/main/product/create')->withInput()->with('validation', $validation);
            }

            // $fileImg = $this->request->getFile('image');
            // if ($fileImg->getError() == 4) {
            //     $nameImg = $this->request->getVar('oldimg');
            // } else {
            //     $nameImg = $fileImg->getRandomName();
            //     $fileImg->move('img/seller', $nameImg);
            //     if ($this->request->getVar('oldimg') != 'default.png') {
            //         unlink('img/seller/' . $this->request->getVar('oldimg'));
            //     }
            // }
            $data = array(
                'name' => $this->request->getPost('name'),
                'qty' => $this->request->getPost('qty'),
                'price' => $this->request->getPost('price'),
                'discount' => $this->request->getPost('discount'),
                'description' => $this->request->getPost('description'),
                'created_at' => $query_product["created_at"],
                'updated_at' => date('Y/m/d h:i:s'),

            );
            $this->M_product->updateProduct($data, $this->request->getPost('id'));
            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('edited', 'Data has been changed');
            }
            return redirect()->to('/main/product');
        } elseif ($url == 'delete' && $id != null) {
            $item = $this->M_product->getproduct($id);
            // if ($item['img'] != 'default.png') {
            //     unlink('img/product/' . $item['img']);
            // }
            $this->M_product->delete($id);
            return redirect()->to('/main/product');
        } elseif ($url == 'detail' && $id != null){
            $query_product = $this->M_product->getProduct($id);
            $data = [
                'title' => 'Detail Product',
                'product' => $query_product
            ];
            return view('admin/product/detail_product', $data);
        }
        $data = [
            'title' => 'product',
            'product' => $this->M_product->getProduct()
        ];
        return view('admin/product/product_view', $data);
    }
    public function categoryProduct($url = 'index', $id = null)
    {
        if ($url == 'create') {
            $data = [
                'title' => 'Add Category Product',
                'validation' => \Config\Services::validation()
            ];
            return view('admin/category_product/add_cat_product', $data);
        } elseif ($url == 'save') {
            if (!$this->validate([
                'name' => [
                    'rules' => 'required',

                ],
                
            ])) {
                $validation = \Config\Services::validation();
                return redirect()->to('/main/categoryproduct/create')->withInput()->with('validation', $validation);
            }
            $str = "";
            $characters = array_merge(range('0', '6'));
            $max = count($characters) - 1;
            for ($i = 0; $i < 6; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            $data = [
                'id_category' => $str,
                'name' => $this->request->getPost('name'),
                'created_at' => date('Y/m/d h:i:s'),

            ];
            $this->M_cat_product->saveCatProduct($data);
            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('success', 'Data saved successfully');
            }
            return redirect()->to('/main/categoryproduct');
        }elseif ($url == 'delete' && $id != null) {
            $item = $this->M_cat_product->getcatproduct($id);
            $this->M_cat_product->delete($id);
            return redirect()->to('/main/categoryproduct');
        } elseif ($url == 'edit' && $id != null) {
            $query_category = $this->M_cat_product->getCatProduct($id);
            $data = [
                'title' => 'Edit Category Product',
                'category' => $query_category,
                'validation' => \Config\Services::validation(),
            ];
            return view('admin/category_product/edit_cat_product', $data);
        }elseif ($url == 'update' && $id != null) {
            $query_category = $this->M_cat_product->getCatProduct($id);
                if (!$this->validate([
                    'name' => [
                        'rules' => 'required',

                    ],
                ])) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('/main/categoryproduct/edit/' . $id)->withInput()->with('validation', $validation);
                }
            $data = array(
                'name' => $this->request->getPost('name'),
                'created_at' => $query_category["created_at"],
            );
            $this->M_cat_product->updateCatProduct($data, $this->request->getPost('id'));
            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('edited', 'Data has been changed');
            }
            return redirect()->to('/main/categoryproduct');
        }
        $data = [
            'title' => 'category product',
            'cat_product' => $this->M_cat_product->getCatProduct()
        ];
        return view('admin/category_product/cat_product_view', $data);
    }
    //menu seller
    // public function 
}
