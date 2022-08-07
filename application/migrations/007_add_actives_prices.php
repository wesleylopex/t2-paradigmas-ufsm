<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_actives_prices extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'active_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'value' => [
        'type' => 'FLOAT',
        'constraint' => 11
      ],
      'date' => [
        'type' => 'timestamp'
      ]
    ]);

    $this->dbforge->add_field('
      CONSTRAINT fk_actives_prices_active_id
        FOREIGN KEY (active_id)
          REFERENCES actives(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('actives_prices');
  }

  public function down () {
    $this->dbforge->drop_table('actives_prices');
  }
}