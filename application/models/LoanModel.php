<?php
class LoanModel extends MY_Model {
	protected $table = 'loans';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';

	public function getAllWithForeign (): array {
		$loans = $this->db
			->select('loans.*, books.title as book_title, users.name as user_name')
			->join('books', 'books.id = loans.book_id')
			->join('users', 'users.id = loans.user_id')
			->get($this->table, $this->field_order, $this->type_order)
			->result();
		return is_array($loans) ? $loans : [];
	}
}
