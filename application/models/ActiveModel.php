<?php
class ActiveModel extends MY_Model {
	protected $table = 'actives';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';

	public function getWithTypes (): array {
		$actives = $this->db->select('actives.*, actives_types.title as type_title')
			->join('actives_types', 'actives_types.id = actives.type_id')
			->get($this->table)->result();

		if (!$actives) return [];

		return $actives;
	}
}
