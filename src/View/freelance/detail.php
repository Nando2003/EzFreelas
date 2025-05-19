<?php
$title = $freelance->getTitle();
ob_start();
?>

<div class="container py-5">
  <div class="card bg-dark text-white mb-4">
    <div class="card-body">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
        <h1 class="display-4 mb-3 mb-md-0">
          <?= htmlspecialchars($freelance->getTitle()) ?>
        </h1>
        <div class="h4 text-success">
          R$ <?= number_format($freelance->getPriceInCents() / 100, 2, ',', '.') ?>
        </div>
      </div>

      <hr class="line my-4">

      <div class="mt-4">
        <div class="fs-4"><strong>Descrição:</strong></div><br>
        <p class="fs-5"><?= nl2br(htmlspecialchars($freelance->getDescription())) ?></p>
      </div>
    </div>
  </div>

  <?php 
    $isOwner = $this->getUserId() === $freelance->getUser()->getId();
  ?>

  <?php if ($isOwner): ?>
    <div class="line mb-3"></div>

    <h3 class="mb-4 text-white">Propostas Recebidas</h3>

    <?php if (empty($proposals)): ?>
      <div class="alert alert-info">Ainda não há propostas.</div>
    <?php else: ?>
      <?php foreach ($proposals as $p): ?>
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <h5 class="card-title mb-0"><?= htmlspecialchars($p->getUser()->getName()) ?></h5>
                <small class="text-muted"><?= htmlspecialchars($p->getUser()->getEmail()) ?></small>
              </div>
              <small class="text-muted">
                <?= $p->getCreatedAt()->format('d/m/Y H:i') ?>
              </small>
            </div>
            <p class="card-text"><?= nl2br(htmlspecialchars($p->getMessage())) ?></p>
            <div class="text-success fw-bold">
              Valor Proposto: R$ <?= number_format($p->getPriceInCents() / 100, 2, ',', '.') ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if ($totalPages > 1): ?>
        <nav aria-label="Paginação de propostas">
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

  <?php else: ?>
    <div class="alert alert-secondary">
      Somente o dono deste anúncio pode ver as propostas.
    </div>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../base.php';
