<div class="main-header">
  <div class="logo-header" data-background-color="primary">
    <a href="<?= base_url('home') ?>" class="logo flex items-center justify-center">
      <img class="w-10" src="<?= base_url('assets/admin/images/wl-logo.png') ?>" alt="Logo" title="Logo" class="navbar-brand">
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <i class="la la-bars"></i>
      </span>
    </button>
    <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
  </div>

  <nav class="navbar navbar-header navbar-expand-lg" data-background-color="primary">
    <div class="container-fluid">
      <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
        <li data-tippy-content="Opções" class="tippy nav-item dropdown hidden-caret">
          <span class="nav-link d-flex dropdown-toggle color-white cursor-pointer" data-toggle="dropdown" href="" aria-expanded="false">
            <i data-feather="settings"></i>
          </span>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <li>
              <div class="user-box">
                <div class="u-text">
                  <h4><?= $user->name ?></h4>
                </div>
              </div>
            </li>
            <li>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= base_url('login/logout') ?>">Sair</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</div>

<div class="sidebar">
  <div class="sidebar-wrapper scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav">
          <?php if (isset($functionalities) && is_array($functionalities) && count($functionalities) > 0) : ?>
            <?php foreach ($functionalities as $headerFunctionality) : ?>
              <li class="nav-item <?= isset($functionality) && $functionality->slug == $headerFunctionality->slug ? 'active' : '' ?>">
                <a href="<?= base_url($headerFunctionality->slug) ?>">
                  <?php if (!empty($headerFunctionality->icon)) : ?>
                    <i><img src="<?= base_url('assets/uploads/images/functionalities/' . $headerFunctionality->icon) ?>" alt=""></i>
                  <?php endif ?>
                  <p><?= $headerFunctionality->title ?></p>
                </a>
              </li>
            <?php endforeach ?>
          <?php endif ?>

        <li class="nav-section">
          <h4 class="text-section">Sair do sistema</h4>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('login/logout') ?>">
            <i data-feather="log-out" class="transform rotate-180"></i>
            <p>Sair</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>