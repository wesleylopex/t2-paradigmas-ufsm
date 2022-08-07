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

		$this->load->view($this->functionalitySlug . '/index', $this->data);
	}
}