<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_admin'          => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
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
				'constraint' => 12,
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
			'img'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'created_at'       => [
				'type'       => 'DATETIME',
				'null'		=> true,
			],
			
		]);
		$this->forge->addKey('id_admin', true);
		$this->forge->createTable('admin');
	}

	public function down()
	{
		$this->forge->dropTable('admin');
	}
}
