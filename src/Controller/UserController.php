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

    public function showLoginForm(string $error = ''): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            header('Location: /home');
            exit;
        }

        require __DIR__ . '/../View/auth/login.php';
    }

    public function showRegisterForm(string $error = ''): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            header('Location: /home');
            exit;
        }

        require __DIR__ . '/../View/auth/register.php';
    }

    public function register(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = $_POST['username'] ?? '';
        $name     = $_POST['name']     ?? '';
        $email    = $_POST['email']    ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($name) || empty($email) || empty($password)) {
            $error = "Todos os campos são obrigatórios";
            $this->showRegisterForm($error);
            return;
        }

        if ($this->userRepository->findByUsername($username)) {
            $error = "Nome de usuário já cadastrado";
            $this->showRegisterForm($error);
            return;
        }

        if ($this->userRepository->findByEmail($email)) {
            $error = "Email já cadastrado";
            $this->showRegisterForm($error);
            return;
        }

        $newUser   = new User($name, $username, $email, $password);
        $wasSaved  = $this->userRepository->create($newUser);

        if (! $wasSaved) {
            $error = "Erro ao cadastrar usuário";
            $this->showRegisterForm($error);
            return;
        }

        $_SESSION['flash_success'] = "Usuário cadastrado com sucesso";
        $saved = $this->userRepository->findByEmail($email);
        $_SESSION['user_id'] = $saved->getId();

        header('Location: /home');
        exit;
    }
    
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['flash_alert'] = "Usuário desconectado com sucesso";
        unset($_SESSION['user_id']);

        header('Location: /home');
        exit;
    }

    public function login(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userRepository->findByUsername($username);
        $error_message = "Usuário ou senha incorretos";
        
        if (!$user) {
            $this->showLoginForm($error_message);
            return;
        }
        
        if (! password_verify($password, $user->getPassword())) {
            $this->showLoginForm($error_message);
            return;
        }

        $_SESSION['user_id']      = $user->getId();
        $_SESSION['flash_success'] = "Usuário logado com sucesso";
        header('Location: /home');
    }
}