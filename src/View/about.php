<?php 
$title = "Sobre nós";
ob_start(); 
?>

<div class="container py-5">

  <h1 class="mb-4">Sobre o EzFreela</h1>

  <p class="lead">
    O <strong>EzFreela</strong> é um sistema web criado como parte da disciplina <strong>Desenvolvimento Web</strong>,
    no curso de Ciência da Computação da <strong>Faculdade Estácio de Sá</strong>.
  </p>

  <p>
    Seu objetivo é demonstrar na prática o uso de PHP moderno, arquitetura MVC, integração com banco de dados
    SQLite, controle de autenticação, organização de rotas e reutilização de templates em aplicações web.
  </p>

  <p>
    Este projeto foi <strong>desenvolvido por Fernando Luiz Farias Fontes</strong> como exercício acadêmico e
    exemplo de aplicação real para portfólio.
  </p>

  <h5 class="mt-4">Entre em contato:</h5>
  <ul class="list-unstyled">
    <li><strong>GitHub:</strong> <a href="https://github.com/Nando2003" target="_blank">github.com/Nando2003</a></li>
    <li><strong>LinkedIn:</strong> <a href="https://www.linkedin.com/in/fernando-luiz-farias-fontes/" target="_blank">
      linkedin.com/in/fernando-luiz-farias-fontes</a></li>
  </ul>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/base.php';
