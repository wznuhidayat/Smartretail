<?php

namespace App\Controllers;

use App\Models\M_admin;
use App\Models\M_seller;


class Auth extends BaseController
{
    public function __construct()
    {
        $this->M_admin = new M_admin();
        $this->M_seller = new M_seller();
    }
    public function index(){
        return redirect()->to(site_url('auth/login'));
    }
	public function login()
	{
		if(session('id_admin')){
            return redirect()->to(site_url('main'));
        }
        return view('admin/login');
	}
    public function loginAdmin(){
        return view('auth/login_admin.php');
    }
    public function loginAdminProcess(){
        $data = $this->M_admin->getAdminByEmail($this->request->getPost('email'));
        if ($data) {
            if ($data['password'] === md5($this->request->getPost('password'))) {
                 $ses_data = [
                    'id_admin'    => $data['id_admin'],
                    'name'     => $data['name'],
                    'email'     => $data['email'],
                    'img'   => $data['img'],
                    'role'     => 'admin'
                ];
                session()->set($ses_data);
                return redirect()->to('/main');
            } else {
                return redirect()->back()->with('error','Your email or password is wrong!');
            }
            
            
        } else {
            return redirect()->back()->with('error','Email is not registered');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
    public function loginSeller()
    {
        return view('auth/login_seller');
    }
    public function loginSellerProcess()
    {
        $data = $this->M_seller->getSellerByEmail($this->request->getPost('email'));
        if ($data) {
            if ($data['password'] === md5($this->request->getPost('password'))) {
                 $ses_data = [
                    'id_seller'    => $data['id_seller'],
                    'name'     => $data['name'],
                    'email'     => $data['email'],
                    'img'   => $data['img'],
                    'role'     => 'seller'
                ];
                session()->set($ses_data);
                return redirect()->to('/main');
            } else {
                return redirect()->back()->with('error','Your email or password is wrong!');
            }
            
            
        } else {
            return redirect()->back()->with('error','Email is not registered');
        }
    }
}
