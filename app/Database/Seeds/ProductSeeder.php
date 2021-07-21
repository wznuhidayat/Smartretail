<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ProductSeeder extends Seeder
{
	public function run()
	{
		
		$faker = \Faker\Factory::create('id_ID');
 
		for ($i = 0; $i < 100; $i++) {		
			$str = "";
            $characters = array_merge(range('0', '6'));
            $max = count($characters) - 1;
            for ($i = 0; $i < 11; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
			$data = [
				'id_product' => $str,
				'id_admin' => 11111111,
				'id_category' => 205644,
				'name' => $faker->name(),
				'qty' => $faker->randomNumber(3, false),
				'price' => $faker->randomNumber(6, false),
				'discount' => $faker->numberBetween(0, 100),
				'description' => $faker->text(100),
				'created_at' => date('Y/m/d h:i:s'),
				'updated_at' => date('Y/m/d h:i:s')
			];
			$this->db->table('product')->insert($data);
		}
	}
}
