<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Productimg extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_product_img'          => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
			],
			'id_product'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '11',
			],
			'img'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
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
		$this->forge->addKey('id_product_img', true);
		$this->forge->addForeignKey('id_product','product','id_product','CASCADE','CASCADE');
		$this->forge->createTable('product_img');
	}

	public function down()
	{
		$this->forge->dropTable('product_img');
	}
}
