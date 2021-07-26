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
			'product_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '11',
			],
			'img'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'create_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
			'update_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
			
		]);
		$this->forge->addKey('id_product_img', true);
		$this->forge->addForeignKey('product_id','product','id_product','CASCADE','CASCADE');
		$this->forge->createTable('product_img');
	}

	public function down()
	{
		$this->forge->dropTable('product_img');
	}
}
