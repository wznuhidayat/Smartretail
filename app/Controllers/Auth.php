<?php

namespace App\Controllers;

use App\Models\M_admin;


class Auth extends BaseController
{
    public function __construct()
    {
        $this->M_admin = new M_admin();
    }
	public function index()
	{
		return view('welcome_message');
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
                    'logged_in'     => TRUE
                ];
                session()->set($ses_data);
                return redirect()->to('/main/admin');
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
}
