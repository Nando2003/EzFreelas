<?php 
$title = "EzFreela";
ob_start(); 
?>

<div class="container py-5">

  <?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert alert-success text-center" role="alert">
      <?= htmlspecialchars($_SESSION['flash_success']) ?>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['flash_alert'])): ?>
    <div class="alert alert-warning text-center" role="alert">
      <?= htmlspecialchars($_SESSION['flash_alert']) ?>
    </div>
    <?php unset($_SESSION['flash_alert']); ?>
  <?php endif; ?>

  <div class="d-flex justify-content-center align-items-center text-center">
    <div class="card bg-dark text-white border-0 shadow-lg p-4 w-100">
      <div class="card-body">
        <h1 class="display-3 fw-bold mb-3">
          Bem-vindo ao <span class="text-primary">EzFreela!</span>
        </h1>
        <p class="lead fst-italic mb-4">
          Conectando freelancers e clientes de forma rápida, segura e eficiente.
        </p>
      </div>
    </div>
  </div>

  <div class="row mt-5 text-center">
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title fw-bold">Fácil de Usar</h5>
          <p class="card-text">Interface intuitiva para encontrar e oferecer serviços rapidamente.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title fw-bold">Grátis</h5>
          <p class="card-text">Totalmente gratuito para freelancers e clientes.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title fw-bold">Contato Direto</h5>
          <p class="card-text">Negocie direto com o profissional, sem intermediários.</p>
        </div>
      </div>
    </div>
  </div>

  <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="text-center my-5">
      <h2 class="fw-bold mb-3">Junte-se agora à comunidade EzFreela</h2>
      <p class="lead">Cadastre-se e comece a contratar ou oferecer serviços em minutos!</p>
      <a href="/register" class="btn btn-success btn-lg px-5 py-2">Quero me cadastrar</a>
    </div>
  <?php endif; ?>
  
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../base.php';
