<?php
$title = 'Minhas Propostas';
ob_start();
?>

<div class="container py-5">

  <h1 class="text-white mb-4"><?= htmlspecialchars($title) ?></h1>

  <?php if (empty($proposals)): ?>
    <div class="alert alert-info">
      Você ainda não enviou nenhuma proposta.
    </div>
  <?php else: ?>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      <?php foreach ($proposals as $p): ?>
        <?php $f = $p->getFreelance(); ?>
        <div class="col">
          <div class="card bg-dark text-white h-100">
            <div class="card-body d-flex flex-column">

              <!-- Título do freelance e data -->
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="card-title mb-0"><?= htmlspecialchars($f->getTitle()) ?></h5>
                <small class="text-muted"><?= $p->getCreatedAt()->format('d/m/Y H:i') ?></small>
              </div>

              <!-- Mensagem da proposta -->
              <p class="card-text flex-grow-1">
                <?= nl2br(htmlspecialchars(mb_strimwidth($p->getMessage(), 0, 200, '...'))) ?>
              </p>

              <!-- Valor proposto e botão -->
              <div class="mt-3 d-flex justify-content-between align-items-center">
                <span class="h5 text-success mb-0">
                  R$ <?= number_format($p->getPriceInCents() / 100, 2, ',', '.') ?>
                </span>
                <a href="/freelance/<?= $f->getId() ?>" class="btn btn-sm btn-secondary">
                  Ver Anúncio
                </a>
              </div>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Paginação -->
    <?php if ($totalPages > 1): ?>
      <nav aria-label="Paginação das minhas propostas" class="mt-5">
        <ul class="pagination justify-content-center">
          <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Anterior</a>
          </li>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
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

<?php
$content = ob_get_clean();
$extraJs = '';
require __DIR__ . '/../base.php';
?>

