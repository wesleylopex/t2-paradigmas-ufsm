<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_roles extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'title' => [
        'type' => 'VARCHAR',
        'constraint' => '100'
      ],
      'description' => [
        'type' => 'TEXT',
        'default' => null
      ]
    ]);
    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('roles');
  }

  public function down () {
    $this->dbforge->drop_table('roles');
  }
}