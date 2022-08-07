<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_transactions extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'user_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'active_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'quantity_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'amount' => [
        'type' => 'FLOAT',
        'constraint' => 11
      ],
      'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ]);

    $this->dbforge->add_field('
      CONSTRAINT fk_transactions_user_id
        FOREIGN KEY (user_id)
          REFERENCES users(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_field('
      CONSTRAINT fk_transactions_active_id
        FOREIGN KEY (active_id)
          REFERENCES actives(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('transactions');
  }

  public function down () {
    $this->dbforge->drop_table('transactions');
  }
}