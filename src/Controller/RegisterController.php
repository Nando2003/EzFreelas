<?php
namespace App\Controller;

use PDO;
use App\Model\User;
use App\Repository\UserRepository;
use App\Controller\BaseController;


class RegisterController extends BaseController {
    private UserRepository $userRepository;

    public function __construct(PDO $pdo) {
        $this->userRepository = new UserRepository($pdo);
    }

    public function get(string $error = ''): void {
        if ($this->getUserId() != null) {
            $this->redirect('/home');
            return;
        }

        require __DIR__ . '/../View/auth/register.php';
    }

    public function post(): void {
        if ($this->getUserId() != null) {
            return;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($name) || empty($email) || empty($password)) {
            $this->get("Todos os campos são obrigatórios");
            return;
        }

        if ($this->userRepository->findByUsername($username)) {
            $this->get("Nome de usuário já cadastrado");
            return;
        }

        if ($this->userRepository->findByEmail($email)) {
            $this->get("Email já cadastrado");
            return;
        }

        $newUser = new User($name, $username, $email, $password);
        $newUser = $this->userRepository->add($newUser);

        $_SESSION['user_id'] = $newUser->getId();
        $_SESSION['flash_success'] = "Usuário cadastrado com sucesso";

        $this->redirect('/home');
    }
}
