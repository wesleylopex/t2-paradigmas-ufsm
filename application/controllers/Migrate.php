<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {
	function __construct () {
		parent::__construct();
	}

	public function index () {
		$this->load->library('migration');

		if ($this->migration->latest() === false) {
			show_error($this->migration->error_string());
		} else {
			echo 'Migrations executadas com sucesso';
		}
	}

	public function rollback (int $version) {
		$this->load->library('migration');

		if ($this->migration->version($version) === false) {
			show_error($this->migration->error_string());
		}
	}
}
