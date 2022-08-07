<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Books extends MainController {
	private $functionalitySlug = 'books';

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

		$this->load->model('BookModel');
		$this->data[$this->functionalitySlug] = $this->BookModel->getAll();

		$this->load->view($this->functionalitySlug . '/index', $this->data);
	}

	public function update (int $bookId) {
		if (!$this->permissions['update']) {
			$this->session->set_flashdata('error', 'Permissão negada');
      return redirect($this->functionalitySlug);
    }

		$this->load->model('BookModel');
		$book = $this->BookModel->getByPrimary($bookId);

		if (empty($book)) {
			return redirect($this->functionalitySlug . '/index');
		}

		$this->data['book'] = $book;

		$this->load->view($this->functionalitySlug . '/form', $this->data);
	}

	public function create () {
		$this->load->view($this->functionalitySlug . '/form', $this->data);
	}

	public function delete (int $bookId) {
		$this->load->model('BookModel');
		$book = $this->BookModel->getByPrimary($bookId);

		if (empty($book)) {
			$this->session->set_flashdata('error', 'Livro não encontrado');
			return redirect('books');
		}

		$this->BookModel->delete($bookId);

		$this->session->set_flashdata('success', 'Livro excluído com sucesso');
		return redirect($this->functionalitySlug);
	}

	public function save () {
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero');
		$this->form_validation->set_rules('title', 'Título', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('authors_name', 'Nome do(s) autor(es)', 'trim|max_length[255]');
		$this->form_validation->set_rules('edition', 'Edição', 'trim|is_natural_no_zero|max_length[11]');
		$this->form_validation->set_rules('publisher', 'Editora', 'trim|max_length[255]');
		$this->form_validation->set_rules('isbn', 'ISBN', 'trim|max_length[255]');
		$this->form_validation->set_rules('year', 'Ano', 'trim|is_natural_no_zero|exact_length[4]');

		if ($this->form_validation->run() !== true) {
			return $this->response(['success' => false, 'error' => strip_tags(validation_errors())]);
		}

		$bookId = $this->input->post('id');
		$bookISBN = $this->input->post('isbn');

		$this->load->model('BookModel');

		$book = [
			'id' => $bookId,
			'title' => $this->input->post('title'),
			'authors_name' => $this->input->post('authors_name'),
			'edition' => $this->input->post('edition'),
			'publisher' => $this->input->post('publisher'),
			'isbn' => $bookISBN,
			'year' => $this->input->post('year'),
		];

		$this->BookModel->save($book);

		return $this->response(['success' => true]);
	}
}