<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_actives_types extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'title' => [
        'type' => 'VARCHAR',
        'constraint' => 255
      ],
      'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
      'updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP'
    ]);

    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('actives_types');
  }

  public function down () {
    $this->dbforge->drop_table('actives_types');
  }
}