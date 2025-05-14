<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'parent_id'         => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'name'              => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'username'          => [
                'type'       => 'VARCHAR',
                'constraint' => 32,
                'unique'     => true,
            ],
            'email'             => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'email_verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'phone'             => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'phone_verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'date_of_birth'     => [
                'type' => 'DATE',
                'null' => true,
            ],
            'gender'            => [
                'type'       => 'ENUM',
                'constraint' => ['male', 'female'],
                'default'    => 'male',
            ],
            'address'           => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'avatar'            => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'password'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'salt'              => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role'              => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'manager', 'editor', 'user'],
                'default'    => 'user',
            ],
            'status'            => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'banned'],
                'default'    => 'active',
            ],
            'is_verified'       => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'reset_token'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at'        => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'        => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
