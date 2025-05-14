<?php 
$title = "Página não encontrada";
ob_start(); 
?>

<div class="container py-5 text-center">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h1 class="display-1 fw-bold text-primary">404</h1>
      <h2 class="mb-4">Página não encontrada</h2>
      <p class="lead mb-4">
        A página que você está procurando não existe ou foi movida.
      </p>
      <a href="/" class="btn btn-primary btn-lg">
        ← Voltar para a página inicial
      </a>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/base.php';
?>
