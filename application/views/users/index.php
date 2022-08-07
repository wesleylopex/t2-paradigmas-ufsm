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
														Adicionar usuário
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
                          <th>Nome</th>
                          <th>Cargo</th>
                          <th>E-mail</th>
                          <th>Criado em</th>
                          <?php if ($permissions['delete']) : ?>
                            <th>Excluir</th>
                          <?php endif ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($users as $currentUser) : ?>
                          <tr data-href="<?= base_url($functionality->slug . '/update/' . $currentUser->id) ?>">
                            <td data-tippy-content="Clique p/ editar"><?= $currentUser->name ?></td>
                            <td data-tippy-content="Clique p/ editar"><?= $currentUser->role_title ?></td>
                            <td data-tippy-content="Clique p/ editar"><?= $currentUser->email ?></td>
                            <td data-tippy-content="Clique p/ editar"><?= date('d/m/Y H:i', strtotime($currentUser->created_at)) ?></td>
                            <?php if ($permissions['delete']) : ?>
                              <td class="not-clickable">
																<?php if ($currentUser->id != $user->id) : ?>
																	<a class="text-blue-600" href="<?= base_url($functionality->slug . '/delete/' . $currentUser->id) ?>">Excluir</a>
																<?php endif ?>
															</td>
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
			redirectToUpdateScreen()
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

		function redirectToUpdateScreen () {
      document.querySelectorAll('td:not(.not-clickable)').forEach(element => {
        element.addEventListener('click', () => {
          window.location.href = element.closest('tr').dataset.href
        })
      })
		}

    function deleteRecord (recordId) {
      console.log(recordId)
    }

		function closeConfirmDeletionModal () {
			const modal = $('#confirm-deletion-modal')
			modal.modal('hide')
		}
	</script>
</body>
</html>