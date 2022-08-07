<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php $this->load->view('imports/head', $this->data) ?>
</head>
<body data-background-color="bg3">
	<div class="wrapper">
		<?php $this->load->view('imports/header', $this->data) ?>
		<div class="main-panel">
			<div class="content">
				<div class="container-fluid">
					<div class="page-header god-header">
						<h4 class="page-title"><?= $functionality->title ?></h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url() ?>">
									home
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<?= $functionality->title ?>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h1 class="text-base font-semibold">Investimentos disponíveis</h1>
								</div>
								<div class="card-body">
									<ul class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-2">
										<?php foreach ($actives as $active) : ?>
										<li class="bg-green-100 rounded-md p-3">
											<div class="flex items-center">
												<div class="bg-black bg-opacity-10 w-min p-2 rounded-md mr-3">
													<i class="feather-xl" data-feather="dollar-sign"></i>
												</div>
												<div>
													<h2 class="font-bold text-base"><?= $active->ticker ?></h2>
													<h3 class="text-gray-500 text-xs"><?= $active->company_name ?></h3>
												</div>
											</div>
											<h4 class="font-semibold text-lg mt-6 currency"><?= $active->price ?></h4>
										</li>
										<?php endforeach ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h2 class="text-base font-semibold">Novo investimento</h2>
								</div>
								<div class="card-body">
									<form id="new-investment" action="<?= base_url('wallet/saveInvestment') ?>">
										<div class="form-row">
											<div class="form-group col-md-2">
												<label for="">Ticker do ativo</label>
												<?= form_dropdown(
													'active_id',
													$activesOptions,
													'',
													['class' => 'form-control', 'onchange' => 'setAmount()', 'required' => 'required']
												) ?>
											</div>
											<div class="form-group col-md-2 mt-6 md:mt-0">
												<label for="">Quantidade</label>
												<input type="number" required name="quantity" min="0" onchange="setAmount()" placeholder="Escolha a quantidade" class="form-control">
											</div>
											<div class="form-group col-md-2 mt-0.5">
												<label for="" class="block">&nbsp;</label>
												<button class="btn btn-primary">Realizar compra</button>
											</div>
										</div>
										<div class="form-row mt-3">
											<div class="form-group col-md-12">
												<h3>Valor total da compra: <span id="amount" class="text-lg text-green-600 font-semibold currency">0</span></h3>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h2 class="text-base font-semibold">Meus investimentos</h2>
									<?php if ($this->session->flashdata('error') || $this->session->flashdata('success')) : ?>
										<?php if ($this->session->flashdata('error')) : ?>
											<div class="mb-4 alert alert-danger d-flex align-items-center justify-content-between" role="alert">
												<?= $this->session->flashdata('error') ?>
												<i class="close" data-feather="x"></i>
											</div>
										<?php endif ?>
										<?php if ($this->session->flashdata('success')) : ?>
											<div class="mb-4 alert alert-primary d-flex align-items-center justify-content-between" role="alert">
												<?= $this->session->flashdata('success') ?>
												<i class="close" data-feather="x"></i>
											</div>
										<?php endif ?>
									<?php endif ?>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="display table table-striped table-hover datatable">
											<thead>
												<tr>
                          <th>Tipo</th>
                          <th>Ticker</th>
                          <th>Quantidade</th>
                          <th>Valor pago</th>
                          <th>Data de compra</th>
													<th>Ações</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($transactions as $transaction) : ?>
													<tr>
														<td><?= $transaction->active_type ?></td>
														<td><?= $transaction->active_ticker ?></td>
														<td><?= $transaction->quantity ?></td>
														<td><span class="currency"><?= $transaction->amount ?></span></td>
														<td><?= date('d/m/Y H:i', strtotime($transaction->created_at)) ?></td>
														<td class="flex items-center">
															<button onclick="deleteTransaction(<?= $transaction->id ?>)" class="text-blue-600 border border-blue-600 py-1 px-2 rounded-md">Vender</button>
															<i class="ml-2 text-blue-600" data-feather="arrow-down-circle"></i>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  <?php $this->load->view('imports/scripts', $this->data) ?>
	
	<script>
		const data = {
			baseURL: '<?= base_url() ?>'
		}

		window.addEventListener('load', function () {
			onQuantityChanges()
			onNewInvestmentFormSubmits()
		})

		function onNewInvestmentFormSubmits () {
			const form = document.querySelector('form#new-investment')

			form.addEventListener('submit', event => {
				event.preventDefault()
				saveInvestment()
			})

			async function saveInvestment () {
				const body = new FormData(form)

				const response = await fetch(form.action, {
					method: 'POST',
					body
				}).then(response => response.json())

				if (response.success !== true) {
					return showNotify(response.error, false)
				}

				showNotify('Investimento realizado com sucesso')
				setTimeout(() => window.location.reload(), 2000)
			}
		}

		function onQuantityChanges () {
			document.querySelector('[name="quantity"]').addEventListener('input', setAmount)
		}

		async function deleteTransaction (transactionId) {
			const activePriceResponse = await fetch(`${data.baseURL}wallet/deleteTransaction?transactionId=${transactionId}`).then(response => response.json())

			if (activePriceResponse.success !== true) {
				return showNotify(activePriceResponse.error, false)
			}

			showNotify('Venda realizada com sucesso')
			setTimeout(() => window.location.reload(), 2000)
		}

		async function setAmount () {
			const activeId = document.querySelector('[name="active_id"]').value
			const quantity = document.querySelector('[name="quantity"]').value

			if (quantity < 0) {
				return showNotify('Quantidade deve ser maior que ZERO', false)
			}

			const activePriceResponse = await fetch(`${data.baseURL}wallet/getActivePrice?activeId=${activeId}`).then(response => response.json())
			
			if (activePriceResponse.success !== true) {
				return showNotify(activePriceResponse.error, false)
			}

			const amount = document.querySelector('#amount')
			amount.innerText = formatCurrency((activePriceResponse.body.price * quantity).toFixed(2))
		}
	</script>
</body>
</html>