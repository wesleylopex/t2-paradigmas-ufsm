<?php
class FunctionalityModel extends MY_Model {
	protected $table = 'functionalities';
	protected $primary = 'id';
	protected $field_order = 'position';
	protected $type_order = 'asc';

	public function getAllByUserId (int $userId): array {
		$functionalities = $this->db
			->select('functionalities.*')
			->join('roles', 'roles.id = users.role_id')
			->join('permissions', 'permissions.role_id = roles.id')
			->join('functionalities', 'functionalities.id = permissions.functionality_id')
			->where('permissions.can_read', true)
			->where('users.id', $userId)
			->order_by('functionalities.position', 'asc')
			->group_by('functionalities.id')
			->get('users')
			->result();

		if (!is_array($functionalities)) {
			return [];
		}

		return $functionalities;
	}
}
