<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_loans extends CI_Migration {
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
      'book_id' => [
        'type' => 'INT',
        'constraint' => 11
      ],
      'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
      'expires_at' => [
        'type' => 'TIMESTAMP'
      ],
      'returned_at' => [
        'type' => 'TIMESTAMP',
        'null' => true,
        'default' => null
      ],
    ]);

    $this->dbforge->add_field('
      CONSTRAINT fk_loans_user_id
        FOREIGN KEY (user_id)
          REFERENCES users(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_field('
      CONSTRAINT fk_loans_book_id
        FOREIGN KEY (book_id)
          REFERENCES books(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
    ');

    $this->dbforge->add_key('id', true);
    $this->dbforge->add_key(['user_id', 'book_id']);
    $this->dbforge->create_table('loans');
  }

  public function down () {
    $this->dbforge->drop_table('loans');
  }
}