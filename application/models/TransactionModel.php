<?php
class TransactionModel extends MY_Model {
	protected $table = 'transactions';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';

	public function getWithForeignData (): array {
		$transactions = $this->db
			->select('
				transactions.*,
				actives_types.title as active_type,
				actives.ticker as active_ticker
			')
			->join('actives', 'actives.id = transactions.active_id')
			->join('actives_types', 'actives_types.id = actives.type_id')
			->get($this->table)->result();

		if (!$transactions) return [];

		return $transactions;
	}
}
