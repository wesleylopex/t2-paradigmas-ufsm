<?php
class TransactionModel extends MY_Model {
	protected $table = 'transactions';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';
}
