<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
  function __construct () {
    parent::__construct();
    $this->data['page'] = 'login';
  }

  public function index () {
    $this->load->view('login', $this->data);
  }

  public function handle () {
    $this->session->unset_userdata('user');

    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    $this->form_validation->set_rules('password', 'Senha', 'trim|required');

    if ($this->form_validation->run() === false) {
      $this->session->set_flashdata('error', strip_tags(validation_errors()));
      return redirect('login');
    }

    $email = antiInjection($this->input->post('email'));

    if (!emailIsValid($email)) {
      $this->session->set_flashdata('error', 'Email inválido');
      return redirect('login');
    }

    $password = antiInjection($this->input->post('password'));

    $this->load->model('UserModel');
    $validUser = $this->UserModel->validate($email, $password);

    if (!$validUser) {
      $this->session->set_flashdata('error', 'Credenciais inválidas');
      return redirect('login');
    }

    $this->session->set_userdata('user', ['id' => $validUser->id]);

    return redirect('home');
  }

  public function logout () {
    $this->session->unset_userdata('user');
    redirect('login');
  }

  public function error () {
    $this->data['page'] = 'error';
    $this->load->view('404', $this->data);
  }

  protected function goToPreviousPage () {
    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }
}