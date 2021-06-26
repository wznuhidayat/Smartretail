<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
	public function run()
	{
		$data = [
			'id_admin' => 11111111,
			'name' => 'Muhammad Azrial',
			'email'    => 'mazrial@gmail.com',
			'phone' => '088788588',
			'password' => md5('1122334455'),
			'gender' => 'male',
			'img' => 'default.png'
		];


		// Using Query Builder
		$this->db->table('admin')->insert($data);
	}
}
