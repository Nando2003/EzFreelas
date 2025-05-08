<?php
namespace App\Controller;

use App\Model\User;
use App\Repository\UserRepository;
use App\Repository\FreelanceRepository;
use App\Repository\ProposalRepository;

use PDO;


class UserController {
    private UserRepository $userRepository;
    private FreelanceRepository $freelanceRepository;
    private ProposalRepository $proposalRepository;

    public function __construct(PDO $pdo) {
        $this->userRepository = new UserRepository($pdo);
        $this->freelanceRepository = new FreelanceRepository($pdo);
        $this->proposalRepository = new ProposalRepository($pdo);
    }

    public function showLoginForm(): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            header('Location: /home');
            exit;
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function showRegisterForm(): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            header('Location: /home');
            exit;
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    public function showProfile(): void {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $user = $this->userRepository->findById($userId);

        if (!$user) {
            header('Location: /login');
            exit;
        }

        $freelances = $this->freelanceRepository->findByUserId($userId);
        $proposals = $this->proposalRepository->findByUserId($userId);
        
        require __DIR__ . '/../views/profile/index.php';
    }

    public function register(): void {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['password2'] ?? '';

        if ($username->empty() || $email->empty() || $password->empty() || $confirm_password->empty()) {
            $error = "Todos os campos são obrigatórios.";
            $this->showRegisterForm();
            return;
        }

        if ($password !== $confirm_password) {
            $error = "As senhas não coincidem.";
            $this->showRegisterForm();
            return;
        }

        if ($this->userRepository->findByEmail($email)) {
            $error = "Este e-mail já está cadastrado.";
            $this->showRegisterForm();
            return;
        }

        $user = new User($username, $email, $password);
        $this->userRepository->create($user);

        header('Location: /login');
        exit;
    }

    public function login(): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($email->empty() || $password->empty()) {
            $error = "Todos os campos são obrigatórios.";
            $this->showLoginForm();
            return;
        }

        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            $error = "E-mail ou senha inválidos.";
            $this->showLoginForm();
            return;
        }

        $_SESSION['user_id'] = $user->getId();

        header('Location: /home');
        exit;
    }

    public function logout(): void {
        session_destroy();
        header('Location: /login');
        exit;
    }
    
}