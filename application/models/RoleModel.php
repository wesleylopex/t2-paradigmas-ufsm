<?php
class RoleModel extends MY_Model {
	protected $table = 'roles';
	protected $primary = 'id';
	protected $field_order = 'title';
	protected $type_order = 'asc';
}
