<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\M_admin;
use App\Models\M_seller;
use App\Models\M_product;
use App\Models\M_product_img;
use App\Models\M_product_sold;
use App\Models\M_cat_product;
use App\Models\Product_Datatable;
use App\Models\Sales_Datatable;
use Config\Services;
use Error;
use phpDocumentor\Reflection\Types\This;

class Main extends BaseController
{
    public $numEpoh = 100;
    public $LR = 0.3;
    public $numHL;
    public $mseStandard = 0.001;
    public $bias= [1,1,1,1];
    public $product = [
        [4, 13, 6, 17],
        [2, 12, 4, 18],
        [0, 14, 2, 10],
        [1, 11, 0, 12]
    ];

    public $target = array(7, 21, 13, 12);
    public $bobotv = [
        [-0.53, -0.1, 0.22, 0.83],
        [-0.84, 0.76, 0.62, 0.35],
        [-0.14, 0.79, 0.57, -0.26],
        [0.75, -0.95, 0.33, -0.7]
    ];
    public $bobotw = array(0.5, 0.73, -0.94, 0.47);

    public $HLIn = array();
    public $HLOut = array();


    public $mseOut = array();


    public $minP = [];
    public $maxP = [];
    public $minT;
    public $maxT;



    public function __construct()
    {
        $this->M_admin = new M_admin();
        $this->M_seller = new M_seller();
        $this->M_product = new M_product();
        $this->M_product_img = new M_product_img();
        $this->M_product_sold = new M_product_sold();
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
            $query_category = $this->M_cat_product->findAll();
            $category[null] = '- Select -';
            foreach ($query_category as $cat) {
                $category[$cat['id_category']] = '[' . $cat['id_category'] . '] - ' . $cat['name'];
            }
            $data = [
                'title' => 'Add Product',
                'validation' => \Config\Services::validation(),
                'selected' => null,
                'category' => $category
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
                'id_category' => $this->request->getPost('id_category'),
                'name' => $this->request->getPost('name'),
                'qty' => $this->request->getPost('qty'),
                'price' => $this->request->getPost('price'),
                'discount' => $this->request->getPost('discount'),
                'description' => $this->request->getPost('description'),
                'created_at' => date('Y/m/d h:i:s'),
                'updated_at' => date('Y/m/d h:i:s'),

            ];
            $this->M_product->saveProduct($data);
            $files = $this->request->getFiles('images');


            if (count(array_filter($_FILES['images']['name'])) != 0) {

                foreach ($this->request->getFileMultiple('images') as $file) {
                    $nameImg = date('ymd') . '-' . substr(md5(rand()), 0, 10);
                    $file->move('img/product', $nameImg);

                    $data = [
                        'id_product_img' =>  rand(),
                        'product_id'  => $str,
                        'img'  =>  $nameImg,
                        'create_at'  => date('Y/m/d h:i:s'),
                        'update_at'  => date('Y/m/d h:i:s'),
                    ];
                    $this->M_product_img->saveImg($data);
                }
            }

            if ($this->db->affectedRows() > 0) {
                session()->setFLashdata('success', 'Data saved successfully');
            }
            return redirect()->to('/main/product');
        } elseif ($url == 'edit' && $id != null) {
            $query_category = $this->M_cat_product->findAll();
            $category[null] = '- Select -';
            foreach ($query_category as $cat) {
                $category[$cat['id_category']] = '[' . $cat['id_category'] . '] - ' . $cat['name'];
            }
            $query_product = $this->M_product->getProduct($id);
            $data = [
                'title' => 'Edit Product',
                'product' => $query_product,
                'validation' => \Config\Services::validation(),
                'selected' => $query_product['id_category'],
                'category' => $category
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
                'id_category' => $this->request->getPost('id_category'),
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
            // $item = $this->M_product->getproduct($id);
            $images = $this->M_product_img->getImgWhereId($id);

            foreach ($images as $imgs) {
                unlink('img/product/' . $imgs['img']);
            }
            $this->M_product->delete($id);
            return redirect()->to('/main/product');
        } elseif ($url == 'detail' && $id != null) {
            $query_product = $this->M_product->getProducts($id);
            $query_img = $this->M_product_img->getImgWhereId($id);
            $data = [
                'title' => 'Detail Product',
                'product' => $query_product,
                'img' => $query_img
            ];
            return view('admin/product/detail_product', $data);
        }
        $data = [
            'title' => 'product',
            'product' => $this->M_product->getProducts()
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
        } elseif ($url == 'delete' && $id != null) {
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
        } elseif ($url == 'update' && $id != null) {
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

    public function sales($url = 'index', $id = null)
    {
        $data = [
            'title' => 'sales data',
            'sales' => $this->M_cat_product->getCatProduct()
        ];
        return view('admin/sales/sales_view', $data);
    }

    // data table list server side 
    public function listProduct()
    {
        $csrfName = csrf_token();
        $csrfHash = csrf_hash();

        $request = Services::request();
        $datatable = new Product_Datatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {

                $no++;
                $row = [];
                $btnEdit = "<a href=\"/main/product/edit/" . $list->id_product . "\" class=\"btn btn-info btn-sm\">Edit</a>";
                $btnDetail = "<a href=\"/main/product/detail/" . $list->id_product . "\" class=\"btn btn-light btn-sm\">Detail</a>";
                //     $btnDelete = " <form action=\"/main/product/delete/".$list->id_product."\" class=\"d-inline\" method=\"post\">
                //     ". csrf_field()." 
                //     <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                //     <button type=\"submit\" class=\"btn btn-danger btn-sm rm\">Delete</button>
                // </form>";

                $btnDelete = "<a href=\"#\" class=\"btn btn-danger btn-sm rm-product\" value=\"" . $list->id_product . "\">delete</a>";
                $row[] = $no;
                $row[] = $list->id_product;
                $row[] = $list->name;
                $row[] = $list->id_category;
                $row[] = $list->qty;
                $row[] = "Rp. " . number_format($list->price, 0, ',', '.');
                $row[] = $btnEdit . $btnDetail . $btnDelete;
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];
            $output[$csrfName] = $csrfHash;
            echo json_encode($output);
        }
    }
    public function listSales()
    {
        $csrfName = csrf_token();
        $csrfHash = csrf_hash();

        $request = Services::request();
        $datatable = new Sales_Datatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {

                $no++;
                $row = [];
                // $btnEdit = "<a href=\"/main/product/edit/".$list->id_product."\" class=\"btn btn-info btn-sm\">Edit</a>";
                $btnDetail = "<a href=\"/main/sales/detail/" . $list->product_id . "\" class=\"btn btn-light btn-sm\">Detail</a>";
                //     $btnDelete = " <form action=\"/main/product/delete/".$list->id_product."\" class=\"d-inline\" method=\"post\">
                //     ". csrf_field()." 
                //     <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                //     <button type=\"submit\" class=\"btn btn-danger btn-sm rm\">Delete</button>
                // </form>";

                // $btnDelete = "<a href=\"#\" class=\"btn btn-danger btn-sm rm-product\" value=\"".$list->id_product."\">delete</a>";
                $row[] = $no;
                $row[] = $list->product_id;
                $row[] = $list->product_name;
                $row[] = "Rp. " . number_format($list->price, 0, ',', '.');
                $row[] = $list->sold_qty;
                $row[] = "Rp. " . number_format($list->sold_qty * $list->price, 0, ',', '.');
                $row[] = $list->name;
                $row[] = $btnDetail;
                $row[] = '';
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];
            $output[$csrfName] = $csrfHash;
            echo json_encode($output);
        }
    }
    public function monthly($url = 'index')
    {
        if($url == 'init'){
            $this->numEpoh = $this->request->getPost('epooch');
            $this->LR = $this->request->getPost('lr');
            $this->mseStandard = $this->request->getPost('mse');

            return redirect()->to('/main/Metodejst')->withInput();
        }
        $data = [
            'title' => 'monthly',
            'monthly_data' => $this->M_product_sold->getMonthly()   
            // 'mse' => $this->mseOut,
            // 'bobotv' => $this->bobotv,
            // 'bobotw' => $this->bobotw,
            // 'bias' => $this->bias,
            // 'mseStd' => $this->mseStandard,
        ];
        return view('admin/monthly/monthly_view', $data);
    }
    public function MetodeJst()
    {
       

        $this->numHL = count($this->product);
        //set min max per row
        $minRest = array();
        $maxRest = array();

        for ($j = 0; $j < count($this->product); $j++) {
            for ($i = 0; $i < count($this->product); $i++) {
                // $this->minP[$i] = min($this->product[$i][]); 
                $minRest[$i] = $this->product[$i][$j];
                $maxRest[$i] = $this->product[$i][$j];

                // array_push($minRest,$i,)
            }
            $this->minP[$j] = min($minRest);
            $this->maxP[$j] = max($maxRest);
        }

        $this->minT = min($this->target);
        $this->maxT = max($this->target);
        //normalisasi 
        $newMin = -1;
        $newMax = 1;

        $newProduct = [];

        for ($j = 0; $j < count($this->product); $j++) {
            for ($i = 0; $i < count($this->product); $i++) {
                $newProduct[$j][$i] = ($this->product[$j][$i] - $this->minP[$i]) / ($this->maxP[$i] - $this->minP[$i]) * ($newMax - $newMin) + $newMin;
            }
        }
        $newTarget = [];
        for ($i = 0; $i < count($this->target); $i++) {
            $newTarget[$i] = ($this->target[$i] - $this->minT) / ($this->maxT - $this->minT) * ($newMax - $newMin) + $newMin;
        }
        // random bobot w
        // $randBobotW = array();
        for ($i=0; $i < count($this->product); $i++) { 
            for ($j=0; $j < $this->numHL; $j++) { 
                $this->bobotv[$i][$j] = rand(-100, 100)/100;
            }
            $this->bobotw[$i] = rand(-100, 100)/100;
        }
        var_dump($this->bobotv);
        //
        // feedforward
        for ($z = 0; $z < $this->numEpoh; $z++) {
            if ($this->mseOut > $this->mseStandard) {

                $newV = [];
                for ($h = 0; $h < count($newProduct); $h++) {
                    for ($j = 0; $j < $this->numHL; $j++) {
                        $restv = 0;
                        for ($i = 0; $i < count($newProduct); $i++) {
                            $restv = $restv + ($newProduct[$j][$i] * $this->bobotv[$i][$h]);
                        }
                        $restv = $restv + $this->bias[$j];
                        for ($k = 0; $k < 4; $k++) {
                            $newV[$h][$j] = $restv;
                        }
                        // echo $restv . ' ';

                        // $restv = 0;
                    }
                }
                //aktivasi ketika akan ke layer hidden
                for ($i = 0; $i < $this->numHL; $i++) {
                    for ($j = 0; $j < count($newV); $j++) {
                        $this->HLIn[$i][$j] = 1 / (1 + exp(-$newV[$i][$j]));
                    }
                }

                // public $bobotw = array(0.5, 0.73, -0.94, 0.47);
                $newW = array();
                for ($i = 0; $i < $this->numHL; $i++) {
                    $restw = 0;
                    for ($j = 0; $j < count($this->bobotw); $j++) {
                        $restw = $restw + ($this->HLIn[$i][$j] * $this->bobotw[$j]);
                    }
                    $restw = $restw + 1;
                    // echo $restw . ' ';
                    for ($k = 0; $k < 4; $k++) {
                        $newW[$i] = $restw;
                    }
                }

                //ouput setelah di aktivasi
                for ($i = 0; $i < $this->numHL; $i++) {
                    $this->HLOut[$i] = 1 / (1 + exp(-$newW[$i]));
                }
                $error = array();
                for ($i = 0; $i < count($this->HLOut); $i++) {
                    $error[$i] =   $newTarget[$i] - $this->HLOut[$i];
                }
                $mseRest = 0;
                for ($i = 0; $i < count($error); $i++) {
                    $mseRest = $mseRest + pow($error[$i], 2);
                }
                $mse = $mseRest / count($error);
                //backpropagation


                //find error
                $errorOut = array();
                for ($i = 0; $i < count($this->HLOut); $i++) {
                    $errorOut[$i] = ($newTarget[$i] - $this->HLOut[$i]) * $this->HLOut[$i] * (1 - $this->HLOut[$i]);
                }

                //koreksi bobot w
                $errorW = array();
                // for ($i=0; $i < count($this->HLIn); $i++) { 
                //     for ($j=0; $j < count($errorOut); $j++) { 
                //         $errorW[$i][$j] = $this->LR * $this->HLIn[$i][$j] * $errorOut[$i];
                //     }
                // }
                for ($i = 0; $i < count($this->HLIn); $i++) {
                    $errorW[$i] = $this->LR * $this->HLOut[$i] * $errorOut[$i];
                }
                //koreksi bias
                $errorBias = array();
                for ($i = 0; $i < count($errorOut); $i++) {
                    $errorBias[$i] = $this->LR *  $errorOut[$i] * $this->bias[$i];
                }

                //hitung delta input hidden
                $errorHL = array();
                for ($i = 0; $i < count($errorOut); $i++) {
                    for ($j = 0; $j < count($this->bobotw); $j++) {
                        $errorHL[$i][$j] = $errorOut[$i] * $this->bobotw[$j];
                    }
                }

                //kalikan dengan turunan aktivasi
                $HslPerkalian = array();
                for ($i = 0; $i < count($this->HLIn); $i++) {
                    for ($j = 0; $j < count($errorHL); $j++) {
                        $HslPerkalian[$i][$j] = $errorHL[$i][$j] * $this->HLIn[$i][$j] * (1 - $this->HLIn[$i][$j]);
                    }
                }

                //hitung perubahan bobot
                $PerubahanBobotV = array();
                for ($i = 0; $i < count($HslPerkalian); $i++) {
                    for ($j = 0; $j < count($newProduct); $j++) {
                        $PerubahanBobotV[$i][$j] = $this->LR * $HslPerkalian[$i][$j] * $newProduct[$i][$j];
                    }
                }
                //update bobot
                // $updBobotW = array();
                for ($j = 0; $j < count($errorW); $j++) {
                    $this->bobotw[$j] = $errorW[$j] + $this->bobotw[$j];
                }

                // $updBobotV = array();
                for ($i = 0; $i < count($PerubahanBobotV); $i++) {
                    for ($j = 0; $j < count($this->bobotv); $j++) {
                        $this->bobotv[$i][$j] = $PerubahanBobotV[$i][$j] + $this->bobotv[$i][$j];
                    }
                }
                for ($i=0; $i < count($this->bias); $i++) { 
                    $this->bias[$i] = $this->bias[$i] + ($this->LR * $errorBias[$i]);
                }
                $this->mseOut = $mse;
            }else{
                break;
            }
            // echo $this->mseOut.'    ';
            // // for ($i=0; $i < count($this->bobotv); $i++) {
            // //     for ($j=0; $j < count($this->bobotv[$i]); $j++) { 
            // //         echo $this->bobotv[$i][$j]. '      ';
            // //     }
            // //     echo '</br>'; 
            // // }
            // echo '</br>'; 
        }
       

        // var_dump($randBobotW);
    }
    public function mon()
    {
        var_dump($this->M_product_sold->getMonthly());
    }

  
}
