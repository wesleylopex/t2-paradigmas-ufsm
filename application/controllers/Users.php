<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MainController {
	private $functionalitySlug = 'users';

  function __construct () {
    parent::__construct();

		$this->load->model('FunctionalityModel');
		$this->functionality = $this->data['functionality'] = $this->FunctionalityModel->getRowWhere(['slug' => $this->functionalitySlug]);

		$this->load->model('PermissionModel');
    $this->permissions = $this->data['permissions'] = $this->PermissionModel->getPermissionsByUser($this->functionalitySlug, $this->user->id);
	}

	public function index () {
		$this->load->model('UserModel');
		$this->data['users'] = $this->UserModel->getAllWithRole();

		$this->load->view($this->functionalitySlug . '/index', $this->data);
	}

	public function update (int $userId) {
		$this->load->model('UserModel');
		$user = $this->UserModel->getByPrimary($userId);

		if (empty($user)) {
			return redirect($this->functionalitySlug . '/index');
		}

		$this->load->model('RoleModel');
		$this->data['roles'] = arrayToFormDropdownOptions($this->RoleModel->getAll(), 'id', 'title');

		$this->data['record'] = $user;

		$this->load->view($this->functionalitySlug . '/form', $this->data);
	}

	public function create () {
		$this->load->model('RoleModel');
		$this->data['roles'] = arrayToFormDropdownOptions($this->RoleModel->getAll(), 'id', 'title');

		$this->load->view($this->functionalitySlug . '/form', $this->data);
	}

	public function delete (int $userId) {
		if ($userId == $this->user->id) {
			$this->session->set_flashdata('error', 'Não é possível excluir o próprio');
			return redirect($this->functionalitySlug);
		}

		$this->load->model('UserModel');
		$user = $this->UserModel->getByPrimary($userId);

		if (empty($user)) {
			$this->session->set_flashdata('error', 'Usuário não encontrado');
			return redirect($this->functionalitySlug);
		}

		$this->UserModel->delete($userId);

		$this->session->set_flashdata('success', 'Usuário excluído com sucesso');
		return redirect($this->functionalitySlug);
	}

	public function save () {
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('role_id', 'Cargo', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('password', 'Senha', 'trim|max_length[255]');

		if ($this->form_validation->run() !== true) {
			return $this->response(['success' => false, 'error' => strip_tags(validation_errors())]);
		}

		$userId = $this->input->post('id');
		$isCreating = empty($userId);

		$this->load->model('UserModel');

		$user = [
			'id' => $userId,
			'name' => $this->input->post('name'),
			'role_id' => $this->input->post('role_id'),
			'email' => $this->input->post('email')
		];

		if ($isCreating || $userId == $this->user->id) {
			$user['password'] = hashPassword($this->input->post('password'));
		}

		$this->UserModel->save($user);

		return $this->response(['success' => true]);
	}
}