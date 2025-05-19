<?php
namespace App\Controller;

use PDO;
use App\Model\Freelance;
use App\Controller\BaseController;
use App\Repository\UserRepository;
use App\Repository\FreelanceRepository;


class FreelanceCreateController extends BaseController  {
    private FreelanceRepository $freelanceRepository;
    private UserRepository $userRepository;

    public function __construct(PDO $pdo) {
        $this->freelanceRepository = new FreelanceRepository($pdo);
        $this->userRepository = new UserRepository($pdo);
    }

    public function get(string $error = ''): void {

        if (!$this->getUserId()) {
            $this->redirect('/home');
            return;
        }

        require __DIR__ . '/../View/freelance/create.php';
    }

    public function post(): void {
        $user_id = $this->getUserId(); 

        if (!$user_id) {
            $this->redirect('/home');
            return;
        }

        $title = $_POST['title'] ?? '';
        $price_str = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';

        $user = $this->userRepository->findById($user_id);

        if (!$user) {
            $this->redirect('/home');
            return;
        }

        if (empty($title) or empty($price_str) or empty($description)) {
            $this->get('Todos os campos são obrigatórios');
            return;
        }

        $price = filter_var($price_str, FILTER_VALIDATE_FLOAT, [
            'options' => ['default' => 0.0]
        ]);

        $priceInCents = (int) round($price * 100);

        $freelance = new Freelance($title, $description, $priceInCents, $user);
        $freelance = $this->freelanceRepository->add($freelance);

        $this->redirect('/freelance/' . $freelance->getId());
    }
    
}