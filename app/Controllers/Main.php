<?php

namespace App\Controllers;

class Main extends BaseController
{
	public function index()
	{
		return view('admin/dashboard');
	}
	public function seller(){
		return view('seller/seller_view');
	}
}
