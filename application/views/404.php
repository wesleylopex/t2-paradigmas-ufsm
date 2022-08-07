<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="<?= base_url('assets/website/styles/tailwindcss/tailwind.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/website/styles/index.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/website/styles/bootstrap-notify/index.css') ?>">

  <link rel="stylesheet" href="<?= base_url('assets/website/styles/font-awesome/styles/all.min.css') ?>">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

  <!-- Google Fonts -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet"> 
</head>
<body class="overflow-x-hidden bg-gray-100">
  <main class="w-screen min-h-screen grid place-items-center px-2 md:px-0">
    <div class="w-full max-w-sm p-6 bg-white rounded-md shadow-md">
      <h1 class="text-dark font-medium text-xl">Página não encontrada</h1>
      <p class="text-gray-500 mt-2 mb-4 text-sm">Parece que a página que você está procurando não existe ou não está disponível.</p>
      <a href="<?= base_url('login') ?>">
        <button class="btn btn--primary w-full">Voltar para o Login</button>
      </a>
    </div>
  </main>
</body>
</html>