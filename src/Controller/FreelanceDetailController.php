<?php
namespace App\Controller;

use PDO;
use App\Controller\BaseController;
use App\Repository\FreelanceRepository;
use App\Repository\ProposalRepository;


class FreelanceDetailController extends BaseController  {
    private FreelanceRepository $freelanceRepository;
    private ProposalRepository $proposalRepository;
    private Handler404Controller $handler404;

    public function __construct(PDO $pdo, Handler404Controller $handler404) {
        $this->freelanceRepository = new FreelanceRepository($pdo);
        $this->proposalRepository = new ProposalRepository($pdo);
        $this->handler404 = $handler404;
    }

    public function get(?int $freelance_id = null, string $error = ''): void {
        if (!$freelance_id) {
            $this->handler404->get();
            return;
        }

        $freelance = $this->freelanceRepository->findById($freelance_id);

        if (!$freelance) {
            $this->handler404->get();
            return;
        }
        
        $user_id = $this->getUserId();
        $proposal = null;
        $proposals  = [];
        $totalPages = 0;
        $currentPage = 1;
        
        error_log('User ID: ' . $user_id);
        error_log('Freelance Owner ID: ' . $freelance->getUser()->getId());
        error_log('Proposals: ' . print_r($proposals, true));

        if ($user_id === $freelance->getUser()->getId()) {
            $currentPage = isset($_GET['page']) && is_numeric($_GET['page'])
                ? max(1, (int) $_GET['page'])
                : 1;

            error_log('Page: ' . $currentPage);

            $perPage = 5;
            $offset  = ($currentPage - 1) * $perPage;
            
            $totalCount = $this->proposalRepository->countByFreelanceId($freelance->getId());
            error_log('Total: ' . $totalCount);

            $proposals = $this->proposalRepository->findByFreelanceIdPaginated($freelance->getId(), $perPage, $offset);
            error_log('Proposals: ' . print_r($proposals, true));

            $totalPages = (int) ceil($totalCount / $perPage);
        }
        else {
            if ($user_id === null) {
                $this->handler404->get();
                return;
            }

            $proposals = $this->proposalRepository->findByUserId($user_id);

            foreach($proposals as $iproposal) {
                if ($iproposal->getFreelance()->getId() === $freelance_id) {
                    $proposal = $iproposal;
                    break;
                }
            }
            
        }

        require __DIR__ . '/../View/freelance/detail.php';
    }
    
}