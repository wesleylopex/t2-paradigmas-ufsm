<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_actives extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'type_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'ticker' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'unique' => true
      ],
      'company_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255
      ]
    ]);

    $this->dbforge->add_field('
      CONSTRAINT fk_actives_type_id
        FOREIGN KEY (type_id)
          REFERENCES actives_types(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('actives');
  }

  public function down () {
    $this->dbforge->drop_table('actives');
  }
}