<?php
namespace App\Controller;

use PDO;
use App\Controller\BaseController;
use App\Repository\FreelanceRepository;

class ProfileFreelancesController extends BaseController {
    private FreelanceRepository $freelanceRepository;

    public function __construct(PDO $pdo)
    {
        $this->freelanceRepository = new FreelanceRepository($pdo);   
    }

    public function get(): void
    {
        $user_id = $this->getUserId();

        if (!$user_id) {
            $this->redirect('/login');
            return;
        }

        // Página atual
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page'])
            ? max(1, (int) $_GET['page'])
            : 1;
        
        $perPage = 10;
        $offset  = ($currentPage - 1) * $perPage;

        // Total de registros e cálculo de páginas
        $totalCount = $this->freelanceRepository->countAll();
        $totalPages = (int) ceil($totalCount / $perPage);

        // Busca os freelances paginados
        $freelances = $this->freelanceRepository->findAllPaginated($perPage, $offset, $user_id);

        // Carrega a view
        require __DIR__ . '/../View/profile/freelances.php';
    }
}
