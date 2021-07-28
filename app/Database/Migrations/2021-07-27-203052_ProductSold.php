<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductSold extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_sold'          => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
			],
			'product_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '11',
			],
			'seller_id'          => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
			],
			'qty'       => [
				'type'       => 'INT',
				'constraint' => 11,
				'null'	=> true,
			],
			'note'       => [
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
		$this->forge->addKey('id_sold', true);
		$this->forge->addForeignKey('product_id','product','id_product');
		$this->forge->addForeignKey('seller_id','seller','id_seller');
		$this->forge->createTable('product_sold');
	}

	public function down()
	{
		$this->forge->dropTable('product_sold');
	}
}
