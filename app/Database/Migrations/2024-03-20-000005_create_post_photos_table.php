<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostPhotosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'    => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
                'after'      => 'id',
                'default'    => 0,
            ],
            'post_id'    => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'file_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 512,
            ],
            'file_path'  => [
                'type'       => 'VARCHAR',
                'constraint' => 512,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('post_photos');
    }

    public function down()
    {
        $this->forge->dropTable('post_photos');
    }
}
