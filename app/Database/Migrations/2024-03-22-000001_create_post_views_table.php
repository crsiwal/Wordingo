<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostViewsTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'post_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'      => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'      => true,
                'default'   => null,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'      => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'referrer' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'device_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'      => true,
                'comment'   => 'mobile/desktop/tablet/bot',
            ],
            'browser' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'      => true,
            ],
            'os' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'      => true,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'      => true,
            ],
            'region' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'      => true,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'      => true,
            ],
            'session_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'      => true,
                'comment'   => 'To track unique views per session',
            ],
            'view_duration' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'      => true,
                'default'   => null,
                'comment'   => 'Time spent viewing in seconds',
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
        $this->forge->addKey('post_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('created_at');
        $this->forge->addKey(['post_id', 'session_id']);
        $this->forge->addKey(['post_id', 'ip_address', 'created_at']);

        $this->forge->createTable('post_views');
    }

    public function down() {
        $this->forge->dropTable('post_views');
    }
}
