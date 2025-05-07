<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Meu Site' ?></title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <nav>
    <a href="/">Home</a> |
    <a href="/contato">Contato</a>
  </nav>

  <main>
    <?= $content ?>
  </main>

  <footer>
    <p>© <?= date('Y') ?></p>
  </footer>
  <script src="/js/app.js" defer></script>
</body>
</html>
