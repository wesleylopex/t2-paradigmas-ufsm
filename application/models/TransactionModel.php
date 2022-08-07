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

		foreach ($transactions as $transaction) {
			$activePrice = $this->db
				->where([
					'active_id' => $transaction->active_id,
					'date' => date('Y-m-d')
				])
				->get('actives_prices')
				->row();
			
			if (empty($activePrice)) {
				$transaction->currentAmount = null;
				$transaction->profitability = null;
			} else {	
				$transaction->currentAmount = $activePrice->value * $transaction->quantity;
				$transaction->profitability = (($transaction->currentAmount / $transaction->amount) - 1) * 100;
			}
		}

		return $transactions;
	}
}
