<?php

namespace App\Controllers;

use App\Models\M_admin;


class Main extends BaseController
{
    public function __construct()
    {
        $this->M_admin = new M_admin();
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
            // session()->setFLashdata('success', 'Data berhasil disimpan');
            return redirect()->to('main/admin');
        } elseif ($url == 'edit' && $id != null) {
            $query_admin = $this->M_admin->getAdmin($id);
            $data = [
                'title' => 'Edit Keluar',
                'admin' => $query_admin,
                'validation' => \Config\Services::validation(),
            ];
            return view('admin/administator/edit_admin', $data);
        } elseif ($url == 'update' && $id != null){
            $query_admin = $this->M_admin->getAdmin($id);
            if ($this->request->getPost('email') == $query_admin['email']){
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
            }elseif($this->request->getPost('email') != $query_admin['email']){
                if ( !$this->validate([
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
            return redirect()->to('/main/admin');
        }elseif ($url == 'delete' && $id != null) {
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
    public function seller()
    {
        $data = [
            'title' => 'Seller',
        ];
        return view('admin/seller/seller_view', $data);
    }
}
