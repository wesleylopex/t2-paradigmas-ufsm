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
                <a href="<?= base_url() ?>"> home </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="<?= base_url($functionality->slug) ?>"><?= $functionality->title ?></a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form id="main-form" action="<?= base_url($functionality->slug . '/save') ?>" method="post">
                  <div class="card-body p-30px">
                    <input type="hidden" name="id" value="<?= isset($record) ? $record->id : '' ?>">
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label class="uppercase text-10px">Nome</label>
                        <input type="text" required class="form-control" name="name" value="<?= isset($record) ? $record->name : '' ?>">
                        <label class="error-label"></label>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="uppercase text-10px">E-mail</label>
                        <input type="text" required class="form-control" name="email" value="<?= isset($record) ? $record->email : '' ?>">
                        <label class="error-label"></label>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="uppercase text-10px">Cargo</label>
                        <?=
                          form_dropdown(
                            'role_id',
                            $roles,
                            isset($record) ? $record->role_id : null,
                            ['required' => true, 'class' => 'form-control']
                          )
                        ?>
                        <label class="error-label"></label>
                      </div>
                      <?php if (!isset($record) || $record->id == $user->id) : ?>
                        <div class="form-group col-md-3">
                          <label class="uppercase text-10px">Senha</label>
                          <input type="password" required class="form-control" name="password">
                          <label class="error-label"></label>
                        </div>
                      <?php endif ?>
                    </div>
                  </div>
                  <div class="card-action">
                    <a href="<?= base_url($functionality->slug) ?>" class="text-black mr-4">
                      Voltar
                    </a>
                    <button class="bg-primary text-white rounded-sm py-1 px-2">
                      Salvar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php $this->load->view('imports/scripts', $this->data) ?>

  <script>
    const settings = {
      baseURL: '<?= base_url() ?>',
      functionality: <?= json_encode($functionality) ?>
    }

    window.addEventListener('load', () => {
      onFormSubmit()
    })

    function onFormSubmit () {
      const form = document.querySelector('#main-form')

      form.addEventListener('submit', async event => {
        event.preventDefault()

        const response = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form)
        }).then(response => response.json())

        if (response.success !== true) {
          showNotify(response.error, false)
          return false
        }

        showNotify('Usuário salvo com sucesso', true)
        setTimeout(() => window.location.href = `${settings.baseURL}${settings.functionality.slug}`, 2000)
      })
    }
  </script>
</body>
</html>