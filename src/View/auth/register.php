<?php 
$title = "Registrar-se";

ob_start(); 
?>
<div class="container py-5 ">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-6">
      <div class="bg-dark rounded p-4">

        <div class="d-flex justify-content-center align-items-center"> 
          <img src="/img/logo2.png" alt="Logo" class="nav__logo mb-0 me-2">
          <h2 class="mb-0">Crie sua conta</h2>
        </div>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger text-center mt-3">
              <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <div class="mt-4">
          <form action="/register" method="post" class="needs-validation" novalidate>

            <div class="mb-3">
              <label for="id_name" class="form-label">Nome</label>
              <input type="text" class="form-control" id="id_name" name="name" placeholder="Digite o seu nome" aria-describedby="nameHelp" required>
              
              <div id="nameHelp" class="form-text">
                <ul class="mb-0 ps-3">
                  <li>Máximo de 225 caracteres: somente letras</li>
                </ul>
              </div>

              <div class="bi bi-exclamation-circle-fill text-danger invalid-feedback">
                <i>Preencha este campo</i>
              </div>
            </div>

            <div class="mb-3">
              <label for="id_username" class="form-label">Usuário</label>
              <input type="text" class="form-control" id="id_username" name="username" placeholder="Digite o seu username" aria-describedby="usernameHelp" required>
              
              <div id="usernameHelp" class="form-text">
                <ul class="mb-0 ps-3">
                  <li>Use entre 4 e 25 caracteres: letras, números e _ (underscore)</li>
                </ul>
              </div>

              <div class="bi bi-exclamation-circle-fill text-danger invalid-feedback">
                <i>Preencha este campo</i>
              </div>
            </div>

            <div class="mb-3">
              <label for="id_email" class="form-label">E-mail</label>
              <input type="text" class="form-control" id="id_email" name="email" placeholder="Digite seu E-mail" aria-describedby="emailHelp" required>
              
              <div id="emailHelp" class="form-text">
                <ul class="mb-0 ps-3">
                  <li>Informe um endereço de e-mail válido (ex: nome@dominio.com)</li>
                </ul>
              </div>

              <div class="bi bi-exclamation-circle-fill text-danger invalid-feedback">
                <i>Preencha este campo</i>
              </div>
            </div>

            <div class="mb-3">
              <label for="id_password" class="form-label">Senha</label>
              <input type="password" class="form-control" id="id_password" name="password" placeholder="Digite sua senha" aria-describedby="passwordHelp" required>
              
              <div id="passwordHelp" class="form-text">
                <ul class="mb-0 ps-3">
                  <li>Ao menos 8 caracteres</li>
                  <li>Uma letra maiúscula (A–Z)</li>
                  <li>Uma letra minúscula (a–z)</li>
                  <li>Um número (0–9)</li>
                  <li>Um caractere especial (ex: !@#$%^&amp;*)</li>
                </ul>
              </div>

              <div class="bi bi-exclamation-circle-fill text-danger invalid-feedback">
                <i>Preencha este campo</i>
              </div>
            </div>

            <div class="mb-3">
              <label for="id_password_confirm" class="form-label">Confirme sua senha</label>
              <input type="password" class="form-control" id="id_password_confirm" name="password_confirm" placeholder="Confirme sua senha" required>

              <div class="bi bi-exclamation-circle-fill text-danger invalid-feedback">
                <i>Preencha este campo</i>
              </div>
            </div>

            <div class="text-center">
              <button type="submit" id="submit_btn" class="btn btn-success mt-2 px-5 py-2 login__button" disabled>Criar</button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
$extraJs = "<script src='/js/register.js'></script>";
require __DIR__ . '/../base.php';
