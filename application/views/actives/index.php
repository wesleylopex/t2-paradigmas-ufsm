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
								<?php if ($permissions['create'] || $this->session->flashdata('error') || $this->session->flashdata('success')) : ?>
									<div class="card-header">
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
										<div class="d-flex align-items-center justify-content-end">
											<?php if ($permissions['create']) : ?>
												<a href="<?= base_url($functionality->slug . '/create') ?>">
													<button data-tippy-content="Adicionar" class="bg-primary text-white rounded-sm py-1 px-2">
														Adicionar ativo
													</button>
												</a>
											<?php endif ?>
										</div>
									</div>
								<?php endif ?>
								<div class="card-body">
									<div class="table-responsive">
										<table class="display table table-striped table-hover datatable">
											<thead>
												<tr>
                          <th>Tipo</th>
                          <th>Ticker</th>
                          <th>Empresa</th>
                          <?php if ($permissions['delete']) : ?>
                            <th>Excluir</th>
                          <?php endif ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($actives as $active) : ?>
                          <tr data-href="<?= base_url($functionality->slug . '/update/' . $active->id) ?>">
                            <td><?= $active->type_title ?></td>
                            <td><?= $active->ticker ?></td>
                            <td><?= $active->company_name ?></td>
                            <?php if ($permissions['delete']) : ?>
                              <td class="not-clickable"><a class="text-blue-600" href="<?= base_url($functionality->slug . '/delete/' . $active->id) ?>">Excluir</a></td>
                            <?php endif ?>
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