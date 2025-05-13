<?php
namespace App\Controller;

use PDO;
use App\Model\Freelance;
use App\Repository\FreelanceRepository;
use App\Repository\ProposalRepository;


class FreelanceController {
    private FreelanceRepository $freelanceRepository;
    private ProposalRepository $proposalRepository;

    /**
     * @var callable
     */
    private $notLoggedIn;

    
    public function __construct(PDO $pdo, callable $notLoggedIn) {
        $this->freelanceRepository = new FreelanceRepository($pdo);
        $this->proposalRepository = new ProposalRepository($pdo);
        $this->notLoggedIn = $notLoggedIn;
    }

    public function getFreelances(): void {
        $userId = $_SESSION["user_id"] ?? null;

        if (! $userId) {
            ($this->notLoggedIn)();
            return;
        }

        $page = isset($_GET['page']) ?max(1, (int)$_GET['page']): 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $freelances = $this->freelanceRepository->findAllPaginated($limit, $offset);
        $total = $this->freelanceRepository->countAll();
        $totalPages = (int)ceil($total / $limit);

        require __DIR__ . '/../View/freelance/getFreelances.php';
    }

    public function getFreelance(int $id): void {
        $userId = $_SESSION["user_id"] ?? null;

        if (! $userId) {
            ($this->notLoggedIn)();
            return;
        }

        $freelance = $this->freelanceRepository->findById($id);

        if (! $freelance) {
            HomeController::getHandler404();
            return;
        }

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        
        $proposals = $this->proposalRepository->findByFreelanceIdPaginated($id, $limit, $offset);
        $totalProposals = $this->proposalRepository->countByFreelanceId($id);
        $totalPages = (int)ceil($totalProposals / $limit);

        require __DIR__ . '/../View/freelance/getFreelance.php';
    }

    public function getFreelanceForm(): void {
        $userId = $_SESSION["user_id"] ?? null;

        if (! $userId) {
            ($this->notLoggedIn)();
            return;
        }

        require __DIR__ . '/../View/freelance/createFreelance.php';
    }

    public function postFreelanceForm(): void {
        $userId = $_SESSION["user_id"] ?? null;

        if (! $userId) {
            return;
        }
    }

    public function deleteFreelance(int $id): void {
        $userId = $_SESSION["user_id"] ?? null;

        if (! $userId) {
            return;
        }
    }

}
