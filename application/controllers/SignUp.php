<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SignUp extends SiteController {
  function __construct () {
    parent::__construct();
    $this->data['page'] = 'sign-up';
  }

  public function handle () {
    try {
      $this->form_validation->set_rules('access_key', 'Chave de acesso', 'trim|required');
      $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[profiles.email]|valid_email', ['is_unique' => 'Este %s já está em uso.']);
      $this->form_validation->set_rules('username', 'Nome de usuário', 'trim|required|is_unique[profiles.username]|alpha_dash', ['is_unique' => 'Este %s já está em uso.']);
      $this->form_validation->set_rules('password', 'Senha', 'trim|required');

      if ($this->form_validation->run() === false) {
        return $this->response(['success' => false, 'error' => strip_tags(validation_errors())]);
      }

      $accessKey = antiInjection($this->input->post('access_key'));

      $this->load->model('AccessKeyModel');
      $accessKeyRecord = $this->AccessKeyModel->getRowWhere(['access_key' => $accessKey, 'profile_id' => null]);
  
      if (empty($accessKeyRecord)) {
        return $this->response(['success' => false, 'error' => 'Chave de acesso não encontrada']);
      }

      $email = antiInjection($this->input->post('email'));

      $user = [
        'username' => antiInjection(strtolower($this->input->post('username'))),
        'email' => $email,
        'password' => hashPassword(antiInjection($this->input->post('password')))
      ];

      $this->load->model('ProfileModel');

      $createdId = $this->ProfileModel->create($user);
      if (!$createdId) {
        return $this->response(['success' => false, 'error' => 'Erro ao criar perfil']);
      }

      $accessKeyInfo = [
        'id' => $accessKeyRecord->id,
        'profile_id' => $createdId
      ];

      $this->AccessKeyModel->update($accessKeyInfo);

      $this->session->set_userdata('user', [
        'id' => $createdId,
        'username' => $user['username']
      ]);

      return $this->response(['success' => true, 'redirect' => base_url('manager')]);
    } catch (\Throwable $th) {
      return $this->response(['success' => false, 'error' => $th->getMessage()]);
    }
    
  }
}