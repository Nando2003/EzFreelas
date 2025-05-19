<?php 
$title = "Criar Freelance";

ob_start(); 
?>
<div class="position-absolute top-50 start-50 translate-middle">
    <div class="container bg-dark p-4 rounded">
      <div class="d-flex justify-content-center align-items-center"> 
          <img src="/img/freelance.png" alt="Logo" class="nav__logo mb-0 me-2">
          <h2 class="mb-0">Faça sua proposta</h2>
      </div>

      <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center mt-3">
          <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <div class="mt-4">
        <form action="/freelance/create" method="post">

          <div class="row mb-3">
            <div class="col-md-8">
              <label for="id_title" class="form-label">Título</label>
              <input type="text" class="form-control" id="id_title" name="title" placeholder="Título do projeto" required>
            </div>

            <div class="col-md-4">
              <label for="id_price" class="form-label">Valor médio</label>
              <input type="text" class="form-control" name="price" id="id_price" inputmode="decimals" placeholder="Ex 100.00" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="id_description" class="form-label">Descrição</label>
            <textarea name="description" class="form-control" aria-describedby="descriptionHelp" id="id_description" rows="5" cols="40" placeholder="Detalhes mais específicos do projeto" required></textarea>
            
            <div id="descriptionHelp" class="form-text">
              <ul class="mb-0 ps-3">
                <li>Descrição deve conter no mínimo 200 caracteres</li>
              </ul>
            </div>
            
          </div>

          <div class="text-center">
            <button type="submit" id="submit_btn" class="btn btn-success mt-2 px-5 py-2 login__button" disabled>Criar</button>
          </div>

        </form>
      </div>
      
    </div>
</div>

<?php
$content = ob_get_clean();
$extraJs = "<script src='/js/freelance_create.js'></script>";
require __DIR__ . '/../base.php';