<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RandomActivesPrices extends MainController {
  function __construct () {
    parent::__construct();
	}

	public function index () {
		$this->load->model('ActiveModel');
		$actives = $this->ActiveModel->getAll();

		$this->load->model('ActivePriceModel');

		$begin = new DateTime('2022-08-01');
		$end = new DateTime('2022-12-31');

		for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
			$min = 1;
			$max = 1000;

			$date = $i->format('Y-m-d');

			foreach ($actives as $active) {
				$price = mt_rand($min * 100, $max * 100) / 100;

				$this->ActivePriceModel->create([
					'active_id' => $active->id,
					'value' => $price,
					'date' => $date
				]);
			}		
		}
	}
}