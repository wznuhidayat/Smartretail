<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CategoryProduct extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_category'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				// 'unsigned'       => true,
			],
			'name'       => [
				'type'       => 'VARCHAR',
				'constraint' => '30',
				'null'	=> true,
			],
			'created_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
			
		]);
		$this->forge->addKey('id_category', true);
		$this->forge->createTable('category_product');
	}

	public function down()
	{
		$this->forge->dropTable('category_product');
	}
}
