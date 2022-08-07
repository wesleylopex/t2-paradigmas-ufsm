<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Loans extends MainController {
	private $functionalitySlug = 'loans';

  function __construct () {
    parent::__construct();

		$this->load->model('FunctionalityModel');
		$this->functionality = $this->data['functionality'] = $this->FunctionalityModel->getRowWhere(['slug' => $this->functionalitySlug]);

		$this->load->model('PermissionModel');
    $this->permissions = $this->data['permissions'] = $this->PermissionModel->getPermissionsByUser($this->functionalitySlug, $this->user->id);
	}

	public function index () {
		if (!$this->permissions['read']) {
			$this->session->set_flashdata('error', 'Permissão negada');
      return redirect('home');
    }

		$this->load->model('LoanModel');
		$this->data['loans'] = $this->LoanModel->getAllWithForeign();

		$this->load->view($this->functionalitySlug . '/index', $this->data);
	}

	public function update (int $loanId) {
		if (!$this->permissions['update']) {
			$this->session->set_flashdata('error', 'Permissão negada');
      return redirect($this->functionalitySlug);
    }

		$this->load->model('LoanModel');
		$loan = $this->LoanModel->getByPrimary($loanId);

		if (empty($loan)) {
			return redirect($this->functionalitySlug . '/index');
		}

		$this->load->model('BookModel');
		$this->data['books'] = arrayToFormDropdownOptions($this->BookModel->getAll(), 'id', 'title');

		$this->load->model('UserModel');
		$this->data['users'] = arrayToFormDropdownOptions($this->UserModel->getAll(), 'id', 'name');

		$this->data['loan'] = $loan;

		$this->load->view($this->functionalitySlug . '/form', $this->data);
	}

	public function create () {
		$this->load->model('BookModel');
		$this->data['books'] = arrayToFormDropdownOptions($this->BookModel->getAll(), 'id', 'title');

		$this->load->model('UserModel');
		$this->data['users'] = arrayToFormDropdownOptions($this->UserModel->getAll(), 'id', 'name');

		$this->load->view($this->functionalitySlug . '/form', $this->data);
	}

	public function delete (int $loanId) {
		$this->load->model('LoanModel');
		$loan = $this->LoanModel->getByPrimary($loanId);

		if (empty($loan)) {
			$this->session->set_flashdata('error', 'Empréstimo não encontrado');
		} else {
			$this->LoanModel->delete($loanId);	
			$this->session->set_flashdata('success', 'Empréstimo excluído com sucesso');
		}

		return redirect($this->functionalitySlug);
	}

	public function save () {
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero');
		$this->form_validation->set_rules('book_id', 'Livro', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('user_id', 'Usuário', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('created_at', 'Data de início', 'trim|required');
		$this->form_validation->set_rules('expires_at', 'Data de fim', 'trim|required');
		$this->form_validation->set_rules('returned_at', 'Data do retorno', 'trim');

		if ($this->form_validation->run() !== true) {
			return $this->response(['success' => false, 'error' => strip_tags(validation_errors())]);
		}

		$loanId = $this->input->post('id');

		$loan = [
			'id' => $loanId,
			'book_id' => $this->input->post('book_id'),
			'user_id' => $this->input->post('user_id'),
			'created_at' => $this->input->post('created_at'),
			'expires_at' => $this->input->post('expires_at')
		];

		if (!empty($loanId) && !empty($this->input->post('returned_at'))) {
			$loan['returned_at'] = $this->input->post('returned_at');
		}

		$this->load->model('LoanModel');
		$this->LoanModel->save($loan);

		return $this->response(['success' => true]);
	}
}