<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Points extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'geom' => [
                'type' => 'GEOMETRY'
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
            'updated_at' => [
                'type' => 'DATETIME'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('points');
    }

    public function down()
    {
        $this->forge->dropTable('points');
    }
}
