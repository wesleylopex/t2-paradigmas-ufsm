<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_functionalities extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'title' => [
        'type' => 'VARCHAR',
        'constraint' => '255'
      ],
      'icon' => [
        'type' => 'VARCHAR',
        'constraint' => '255'
      ],
      'position' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'slug' => [
        'type' => 'VARCHAR',
        'constraint' => '255',
        'unique'=> true
      ],
    ]);

    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('functionalities');
  }

  public function down () {
    $this->dbforge->drop_table('functionalities');
  }
}