<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wallet extends MainController {
	private $functionalitySlug = 'wallet';

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

		$this->load->model('ActiveModel');

		$this->data['actives'] = $this->ActiveModel->getWithPrices();
		$this->data['activesOptions'] = arrayToFormDropdownOptions($this->ActiveModel->getAll(), 'id', 'ticker');

		$this->load->model('TransactionModel');
		$this->data['transactions'] = $this->TransactionModel->getWithForeignData();

		$this->load->view($this->functionalitySlug . '/index', $this->data);
	}

	public function getActivePrice () {
		$activeId = $this->input->get('activeId');

		$this->load->model('ActivePriceModel');
		$activePrice = $this->ActivePriceModel->getRowWhere(['active_id' => $activeId, 'date' => date('Y-m-d')]);

		if (!$activePrice) {
			return $this->response(['success' => false, 'error' => 'Ativo não encontrado']);
		}

		return $this->response([
			'success' => true,
			'body' => [
				'price' => $activePrice->value
			]
		]);
	}

	public function deleteTransaction () {
		$transactionId = $this->input->get('transactionId');

		$this->load->model('TransactionModel');
		$transaction = $this->TransactionModel->getRowWhere(['id' => $transactionId, 'user_id' => $this->user->id]);

		if (!$transaction) {
			return $this->response(['success' => false, 'error' => 'Transação não encontrada']);
		}

		$this->TransactionModel->delete($transactionId);

		return $this->response(['success' => true]);
	}

	public function saveInvestment () {
		$this->form_validation->set_rules('active_id', 'Ativo', 'required|integer');
		$this->form_validation->set_rules('quantity', 'Quantidade', 'required|integer');

		if ($this->form_validation->run() == false) {
			return $this->response(['success' => false, 'error' => strip_tags(validation_errors())]);
		}

		$activeId = $this->input->post('active_id');
		$quantity = $this->input->post('quantity');

		$this->load->model('ActivePriceModel');
		$activePrice = $this->ActivePriceModel->getRowWhere(['active_id' => $activeId, 'date' => date('Y-m-d')]);

		if (!$activePrice) {
			return $this->response(['success' => false, 'error' => 'Ativo não encontrado']);
		}

		$transaction = [
			'user_id' => $this->user->id,
			'active_id' => $activeId,
			'quantity' => $quantity,
			'amount' => $activePrice->value * $quantity
		];

		$this->load->model('TransactionModel');
		$this->TransactionModel->create($transaction);

		return $this->response(['success' => true]);
	}
}