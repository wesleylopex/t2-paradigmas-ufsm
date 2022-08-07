<?php
class UserModel extends MY_Model {
	protected $table = 'users';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';

	public function validate (string $email, string $password) {
		$email = antiInjection($email, true);
		$password = antiInjection($password, true);

		$user = $this->getRowWhere(['email' => $email]);

		if (!$user) {
			return false;
		}

		$isPasswordValid = compareHash($password, $user->password);

		if ($isPasswordValid) {
			return $user;
		}

		return false;
	}

	public function getAllWithRole (): array {
		$users = $this->db
			->select('users.*, roles.title as role_title')
			->join('roles', 'roles.id = users.role_id', 'left')
			->get($this->table, $this->field_order, $this->type_order)
			->result();
		return is_array($users) ? $users : [];
	}
}
