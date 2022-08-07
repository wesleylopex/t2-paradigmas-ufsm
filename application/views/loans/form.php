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
                    <input type="hidden" name="id" value="<?= isset($loan) ? $loan->id : '' ?>">
                    <div class="form-row">
                      <div class="form-group col-md-2">
                        <label class="uppercase text-10px">Livro</label>
                        <?=
                          form_dropdown(
                            'book_id',
                            $books,
                            isset($loan) ? $loan->book_id : null,
                            ['required' => true, 'class' => 'form-control']
                          )
                        ?>
                        <label class="error-label"></label>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="uppercase text-10px">Usuário</label>
                        <?=
                          form_dropdown(
                            'user_id',
                            $users,
                            isset($loan) ? $loan->user_id : null,
                            ['required' => true, 'class' => 'form-control']
                          )
                        ?>
                        <label class="error-label"></label>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="uppercase text-10px">Data de início</label>
                        <input type="date" required class="form-control" name="created_at" value="<?= isset($loan) ? date('Y-m-d', strtotime($loan->created_at)) : '' ?>">
                        <label class="error-label"></label>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="uppercase text-10px">Data de fim</label>
                        <input type="date" required class="form-control" name="expires_at" value="<?= isset($loan) ? date('Y-m-d', strtotime($loan->expires_at)) : '' ?>">
                        <label class="error-label"></label>
                      </div>
                      <?php if (isset($loan)) : ?>
                        <div class="form-group col-md-2">
                          <label class="uppercase text-10px">Data do retorno</label>
                          <input type="date" class="form-control" name="returned_at" value="<?= !empty($loan->returned_at) ? date('Y-m-d', strtotime($loan->returned_at)) : '' ?>">
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

        showNotify('Empréstimo salvo com sucesso', true)
        setTimeout(() => window.location.href = `${settings.baseURL}${settings.functionality.slug}`, 2000)
      })
    }
  </script>
</body>
</html>