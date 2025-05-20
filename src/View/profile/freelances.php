<?php
$title = 'Meus Freelances';
ob_start();
?>

<div class="container py-5">
  <h1 class="text-white mb-4"><?= htmlspecialchars($title) ?></h1>

  <?php if (empty($freelances)): ?>
    <div class="alert alert-info">Você ainda não publicou nenhum freelance.</div>
  <?php else: ?>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      <?php foreach ($freelances as $f): ?>
        <div class="col">
          <div class="card bg-dark text-white h-100">
            <div class="card-body d-flex flex-column">

              <!-- Título e data -->
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="card-title mb-0"><?= htmlspecialchars($f->getTitle()) ?></h5>
                <small class="text-muted">
                  <?= $f->getCreatedAt()->format('d/m/Y H:i') ?>
                </small>
              </div>

              <!-- Descrição resumida -->
              <p class="card-text flex-grow-1">
                <?= nl2br(htmlspecialchars(mb_strimwidth($f->getDescription(), 0, 150, '...'))) ?>
              </p>

              <!-- Preço e botões -->
              <div class="mt-3 d-flex justify-content-between align-items-center">
                <span class="h5 text-success mb-0">
                  R$ <?= number_format($f->getPriceInCents() / 100, 2, ',', '.') ?>
                </span>
                <div>
                  <a href="/freelance/<?= $f->getId() ?>" class="btn btn-sm btn-secondary">
                    Ver detalhes
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Paginação -->
    <?php if ($totalPages > 1): ?>
      <nav aria-label="Paginação dos meus freelances" class="mt-5">
        <ul class="pagination justify-content-center">
          <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Anterior</a>
          </li>
          <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <li class="page-item <?= $p === $currentPage ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Próxima</a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>

  <?php endif; ?>
</div>

<!-- Botão flutuante "+" -->
<a href="/freelance/create"
   class="btn btn-primary rounded-circle shadow-lg position-fixed login__button"
   style="bottom: 40px; right: 40px; width: 60px; height: 60px; font-size: 30px; display: flex; align-items: center; justify-content: center; z-index: 1000;"
   title="Criar novo freelance">
  +
</a>

<?php
$content = ob_get_clean();
$extraJs = '';
require __DIR__ . '/../base.php';
