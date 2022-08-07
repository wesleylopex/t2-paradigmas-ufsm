<?php
class PermissionModel extends MY_Model {
	protected $table = 'permissions';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';

	public function getPermissions () {
		$permissions = $this->db
			->select('permissions.*, roles.title AS profile_title, functionalities.title AS functionality_title')
			->join('roles', 'roles.id = permissions.role_id')
			->join('functionalities', 'functionalities.id = permissions.functionality_id')
			->get($this->table)->result();

		return $permissions;
	}

	public function getPermissionsByUser (string $functionalitySlug, int $userId) : array{
		$permissions = $this->db
			->select('permissions.*')
			->join('users', 'users.id = ' . $userId)
			->join('permissions', 'permissions.functionality_id = functionalities.id AND permissions.role_id = users.role_id')
			->get_where('functionalities', ['functionalities.slug' => $functionalitySlug]);

		if ($permissions->num_rows() !== 1) {
			return [
        'read' => false,
        'create' => false,
        'update' => false,
        'delete' => false
      ];
		}
		
		$permissions = $permissions->row();

    return [
      'read' => $permissions->can_read,
      'create' => $permissions->can_create,
      'update' => $permissions->can_update,
      'delete' => $permissions->can_delete,
    ];
	}
}
