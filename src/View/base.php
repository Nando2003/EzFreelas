<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? ''?></title>

  <link rel="icon" type="image/x-icon" href="/img/favicon.ico">

  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/darkly/bootstrap.min.css"
    crossorigin="anonymous"/>

  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap"
    rel="stylesheet"/>

  <link rel="stylesheet" href="css/style.css">

  <?= $extraCss ?? '' ?>
</head>

<body>

  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="/">
          <img src="img/logo2.png" alt="Logo" class="nav__logo me-2">
          <span class="text-white text-uppercase fw-bold fs-3">EzFreela</span>
        </a>

        <!-- Botão de toggle em telas pequenas -->
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarContent"
          aria-controls="navbarContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarContent">
          <ul class="navbar-nav align-items-center">

            <li class="nav-item">
              <a class="nav-link link-light" href="/about">Sobre</a>
            </li>

            <?php if (isset($_SESSION['user_id'])): ?>

            <li class="nav-item">
              <a class="nav-link link-light" href="#">Freelas</a>
            </li>

            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle link-light"
                href="#"
                id="userDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                Eu
              </a>

              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="/profile">Meu perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="/logout" method="post" class="d-inline">
                    <button class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
            </li>

            <?php else: ?>

            <li class="nav-item">
              <a class="nav-link link-light" href="/login">Entrar</a>
            </li>

            <li class="nav-item">
              <a class="nav-link link-light" href="/register">Registrar-se</a>
            </li>

            <?php endif; ?>

          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <?= $content ?? '' ?>
  </main>

  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"  
    crossorigin="anonymous"></script>

  <?= $extraJs ?? '' ?>
</body>

</html>