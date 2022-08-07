<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MainController extends CI_Controller {
  public $data = [];
  public $user = null;

  protected function __construct () {
    parent::__construct();

    $sessionUser = $this->getUserOrRedirect();

    $this->load->model('UserModel');
    $this->data['user'] = $this->user = $this->UserModel->getByPrimary($sessionUser['id']);

    $this->load->model('FunctionalityModel');
    $this->data['functionalities'] = $this->FunctionalityModel->getAllByUserId($this->user->id);

    $this->load->vars($this->data);
  }

  private function getUserOrRedirect () {
    $user = $this->session->userdata('user');

    if (!is_array($user) || empty($user)) {
      redirect('login');
    }

    return $user;
  }

  protected function goToPreviousPage () {
    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }

  protected function response (array $response) : bool {
    echo json_encode($response);
    return array_key_exists('success', $response) ? $response['success'] : false;
  }
}
