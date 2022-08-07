<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_permissions extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'role_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'functionality_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'can_create' => [
        'type' => 'BOOLEAN',
        'default' => true
      ],
      'can_read' => [
        'type' => 'BOOLEAN',
        'default' => true
      ],
      'can_update' => [
        'type' => 'BOOLEAN',
        'default' => true
      ],
      'can_delete' => [
        'type' => 'BOOLEAN',
        'default' => true
      ],
    ]);

    $this->dbforge->add_field('
      CONSTRAINT fk_permissions_role_id
        FOREIGN KEY (role_id)
          REFERENCES roles(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_field('
      CONSTRAINT fk_permissions_functionality_id
        FOREIGN KEY (functionality_id)
          REFERENCES functionalities(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_key('id', true);
    $this->dbforge->add_key(['role_id', 'functionality_id']);
    $this->dbforge->create_table('permissions');
  }

  public function down () {
    $this->dbforge->drop_table('permissions');
  }
}