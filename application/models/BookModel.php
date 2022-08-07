<?php
class BookModel extends MY_Model {
	protected $table = 'books';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';
}
