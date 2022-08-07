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
									<h1 class="text-base font-semibold">Seus investimentos</h1>
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
                          <th>Título do ativo</th>
                          <th>Quantidade</th>
                          <th>Valor pago</th>
                          <?php if ($permissions['delete']) : ?>
                            <th>Excluir</th>
                          <?php endif ?>
												</tr>
											</thead>
											<tbody>
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
		window.addEventListener('load', function () {
			closeAlert()
		})

		function closeAlert () {
			const alert = document.querySelector('.alert')
			if (!alert) return null
			const close = alert.querySelector('.close')
			close.addEventListener('click', () => {
				alert.remove()
			})
		}
	</script>
</body>
</html>