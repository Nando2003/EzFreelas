<?php 
$title = "Perfil";

ob_start(); 
?>
<div class="position-absolute top-50 start-50 translate-middle">
    <div class="container bg-dark p-4 rounded">

        <div class="d-flex justify-content-center align-items-center"> 
          <img src="/img/logo2.png" alt="Logo" class="nav__logo mb-0 me-2">
          <h2 class="mb-0">Olá, <?= htmlspecialchars($userObj->getUsername()) ?></h2>
        </div>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger text-center mt-3">
              <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_success'])): ?>
          <div class="alert alert-success text-center mt-3" role="alert">
            <?= htmlspecialchars($_SESSION['flash_success']) ?>
          </div>
          <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <div class="mt-4">
          <form action="/profile/update" method="post" class="needs-validation" novalidate>

            <div class="mb-3">
              <label for="id_name" class="form-label">Nome</label>
              <input type="text" value="<?= htmlspecialchars($userObj->getName()) ?>" class="form-control" id="id_name" name="name" disabled>
            </div>

            <div class="mb-3">
              <label for="id_username" class="form-label">Usuário</label>
              <input type="text" value="<?= htmlspecialchars($userObj->getUsername()) ?>" class="form-control" id="id_username" name="username" placeholder="Digite o seu username" disabled>
            </div>

            <div class="mb-4">
              <label for="id_email" class="form-label">E-mail</label>
              <input type="text" value="<?= htmlspecialchars($userObj->getEmail()) ?>" class="form-control" id="id_email" name="email" placeholder="Digite seu E-mail" disabled>
            </div>

            <div class="text-center d-flex justify-content-center gap-3" id="button-group">
              <button type="button" id="edit_btn" class="btn btn-info px-4 py-2 login__button">Atualizar</button>
              <button type="submit" id="delete_btn" name="action" value="delete" class="btn btn-danger px-4 py-2 login__button">Deletar</button>
            </div>

            <div class="text-center d-flex justify-content-center gap-3 d-none" id="edit-actions">
              <button type="submit" name="action" value="update" class="btn btn-success px-4 py-2 login__button">Salvar</button>
              <button type="button" id="cancel_btn" class="btn btn-secondary px-4 py-2 login__button">Cancelar</button>
            </div>

          </form>
        </div>

  </div>
</div>
<?php
$content = ob_get_clean();
$extraJs = "<script src='/js/edit_profile.js'></script>";
require __DIR__ . '/../base.php';
