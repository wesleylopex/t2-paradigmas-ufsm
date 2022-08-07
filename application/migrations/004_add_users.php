<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'role_id' => [
        'type' => 'INT',
        'constraint' => 11,
        'null' =>  true
      ],
      'name' => [
        'type' => 'VARCHAR',
        'constraint' => '255'
      ],
      'email' => [
        'type' => 'VARCHAR',
        'constraint' => '255',
        'unique' => true
      ],
      'password' => [
        'type' => 'VARCHAR',
        'constraint' => '255'
      ],
      'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
      'updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP'
    ]);

    $this->dbforge->add_field('
      CONSTRAINT fk_users_role_id
        FOREIGN KEY (role_id)
          REFERENCES roles(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('users');
  }

  public function down () {
    $this->dbforge->drop_table('users');
  }
}