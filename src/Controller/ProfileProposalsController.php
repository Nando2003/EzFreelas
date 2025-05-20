<?php
namespace App\Controller;

use PDO;
use App\Controller\BaseController;
use App\Repository\ProposalRepository;


class ProfileProposalsController extends BaseController {
    private ProposalRepository $proposalRepository; 

    public function __construct(PDO $pdo)
    {
        $this->proposalRepository = new ProposalRepository($pdo);   
    }

    public function get(): void
    {
        $user_id = $this->getUserId();

        if (!$user_id) {
            $this->redirect('/login');
            return;
        }

        $currentPage = isset($_GET['page']) && is_numeric($_GET['page'])
            ? max(1, (int) $_GET['page'])
            : 1;
        
        $perPage = 10;
        $offset  = ($currentPage - 1) * $perPage;

        $totalCount = count($this->proposalRepository->findAllByUserId($user_id));
        $totalPages = (int) ceil($totalCount / $perPage);

        $proposals = $this->proposalRepository->findByUserIdPaginated($user_id, $perPage, $offset);
    
        require __DIR__ . '/../View/profile/proposals.php';
    }
}