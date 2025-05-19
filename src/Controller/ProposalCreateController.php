<?php
namespace App\Controller;

use PDO;
use App\Model\Proposal;
use App\Repository\ProposalRepository;
use App\Controller\BaseController;
use App\Repository\UserRepository;
use App\Controller\Handler404Controller;
use App\Repository\FreelanceRepository;


class ProposalCreateController extends BaseController {
    private ProposalRepository $proposalRepository;
    private FreelanceRepository $freelanceRepository;
    private Handler404Controller $handler404;
    private UserRepository $userRepository;

    public function __construct(PDO $pdo, Handler404Controller $handler404) {
        $this->proposalRepository = new ProposalRepository($pdo);
        $this->freelanceRepository = new FreelanceRepository($pdo);
        $this->userRepository = new UserRepository($pdo);
        $this->handler404 = $handler404;
    }

    public function post(?int $freelance_id = null): void {
        $user_id = $this->getUserId();

        if (!$freelance_id or !$user_id) {
            $this->handler404->get();
            return;
        }

        $message = $_POST['message'] ?? '';
        $price_str = $_POST['price'] ?? '';

        if (empty($message) or empty($price_str)) {
            $this->get('Todos os campos são obrigatórios');
            return;
        }

        $user = $this->userRepository->findById($user_id);
        $freelance = $this->freelanceRepository->findById($freelance_id);

        if (!$user or !$freelance) {
            $this->handler404->get();
            return;
        }

        $price = filter_var($price_str, FILTER_VALIDATE_FLOAT, [
            'options' => ['default' => 0.0]
        ]);

        $priceInCents = (int) round($price * 100);

        $proposal = new Proposal($message, $priceInCents, $user, $freelance);
        $this->proposalRepository->add($proposal);
        
        $this->redirect(('/freelance/') . $freelance_id);
    }
}