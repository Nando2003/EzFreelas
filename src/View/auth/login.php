<?php 
$title = "Entrar";

ob_start(); 
?>
<div class="position-absolute top-50 start-50 translate-middle">
  <div class="container bg-dark p-4 rounded">

    <div class="d-flex text-center align-items-center"> 
      <img src="/img/logo2.png" alt="Logo" class="nav__logo mb-0 me-2">
      <h2 class="mb-0">Acesse os Freelas</h2>
    </div>

    <div class="mt-4">

        <?php if (! empty($error)): ?>
          <div class="alert alert-danger text-center mt-3">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

      <form action="/login" method="post" class="needs-validation" novalidate>

        <div class="mb-3">
          <label for="id_username" class="form-label">Usuário</label>
          <input type="text" class="form-control" id="id_username" name="username" placeholder="Digite o seu username" required>
          
          <div class="bi bi-exclamation-circle-fill text-danger invalid-feedback">
            <i>Preencha este campo</i>
          </div>
        </div>

        <div class="mb-3">
          <label for="id_password" class="form-label">Senha</label>
          <input type="password" class="form-control" id="id_password" name="password"  placeholder="Digite o sua senha" required>
          
          <div class="bi bi-exclamation-circle-fill text-danger invalid-feedback">
            <i>Preencha este campo</i>
          </div>
        </div>
        
        <div class="text-center">
          <button type="submit" id="submit_btn" class="btn btn-primary mt-2 px-5 py-2 login__button">Entrar</button>
        </div>

      </form>
    </div>
    
  </div>  
</div>
<?php
$content = ob_get_clean();
$extraJs = "<script src='/js/login.js'></script>";
require __DIR__ . '/../base.php';
