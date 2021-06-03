<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_product'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '11',
			],
			'id_admin'          => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'unique'         => true,
			],
			'name'       => [
				'type'       => 'VARCHAR',
				'constraint' => '30',
				'null'	=> true,
			],
			'qty'       => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'       => true,
				'null'	=> true,
			],
			'price'       => [
				'type'       => 'INT',
				'constraint' => 30,
				'null'	=> true,
				'unsigned'       => true,
			],
			'discount'       => [
				'type'       => 'INT',
				'constraint' => 3,
			],
			'description'       => [
				'type'       => 'VARCHAR',
				'constraint' => '30',
				'null'	=> true,
				
			],
			'created_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
			'updated_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
		]);
		
		$this->forge->addKey('id_product', true);
		$this->forge->addForeignKey('id_admin','admin','id_admin');
		$this->forge->createTable('product');
		
	}

	public function down()
	{
		$this->forge->dropTable('product');
	}
}
