<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductTest extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_product_test'          => [
				'type'           => 'INT',
				'constraint'     => 8,
				// 'unsigned'       => true,
			],
			'product_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '11',
				// 'unsigned'       => true,
			],
			'x1'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'x2'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'x3'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'x4'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'x5'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'x6'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'target'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'create_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
			
		]);
		$this->forge->addKey('id_product_test', true);
		$this->forge->addForeignKey('product_id','product','id_product');
		$this->forge->createTable('product_test');
	}

	public function down()
	{
		$this->forge->dropTable('product_test');
	}
}
