<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MainController {
  function __construct () {
    parent::__construct();
    $this->data['page'] = 'home';

		$this->load->model('FunctionalityModel');
		$this->functionality = $this->data['functionality'] = $this->FunctionalityModel->getRowWhere(['slug' => 'home']);

		$this->load->model('PermissionModel');
    $this->permissions = $this->data['permissions'] = $this->PermissionModel->getPermissionsByUser('home', $this->user->id);
  }

  public function index () {
    redirect('wallet');
    $this->load->view('home', $this->data);
  }

  public function error () {
    $this->data['page'] = 'error';
    $this->load->view('404', $this->data);
  }
}