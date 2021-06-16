<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Seller extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_seller'          => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
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
			'email'       => [
				'type'       => 'VARCHAR',
				'constraint' => '30',
				'unique'         => true,
			],
			'phone'       => [
				'type'       => 'INT',
				'constraint' => '16',
			],
			'password'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'gender'       => [
				'type'       => 'ENUM',
				'constraint' => ['male', 'female'],
				'null'		=> true,
			],
			'address'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'img'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'created_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
			
		]);
		$this->forge->addKey('id_seller', true);
		$this->forge->addForeignKey('id_admin','admin','id_admin');
		$this->forge->createTable('seller');
	}

	public function down()
	{
		$this->forge->dropTable('seller');
	}
}
