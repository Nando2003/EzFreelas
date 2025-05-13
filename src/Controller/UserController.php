<?php
namespace App\Controller;

use App\Model\User;
use App\Repository\UserRepository;

use PDO;


class UserController {
    private UserRepository $userRepository;

    /**
     * @var callable
     */
    private $onLoggedIn;

    public function __construct(PDO $pdo, callable $onLoggedIn) {
        $this->userRepository = new UserRepository($pdo);
        $this->onLoggedIn = $onLoggedIn;
    }

    public function gotoLoginForm(): void {
        header("Location: /login");
        exit;
    }

    public function getLoginForm(string $error = ''): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            ($this->onLoggedIn)();
        }

        require __DIR__ . '/../View/auth/login.php';
    }

    public function getRegisterForm(string $error = ''): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            ($this->onLoggedIn)();
        }

        require __DIR__ . '/../View/auth/register.php';
    }
    
    public function postRegisterForm(): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            return;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($name) || empty($email) || empty($password)) {
            $this->getRegisterForm("Todos os campos são obrigatórios");
            return;
        }

        if ($this->userRepository->findByUsername($username)) {
            $this->getRegisterForm("Nome de usuário já cadastrado");
            return;
        }

        if ($this->userRepository->findByEmail($email)) {
            $this->getRegisterForm("Email já cadastrado");
            return;
        }

        $newUser = new User($name, $username, $email, $password);
        $wasSaved = $this->userRepository->create($newUser);

        if (! $wasSaved) {
            $this->getRegisterForm("Erro ao cadastrar usuário");
            return;
        }

        $saved = $this->userRepository->findByEmail($email);

        $_SESSION['user_id'] = $saved->getId();
        $_SESSION['flash_success'] = "Usuário cadastrado com sucesso";

        ($this->onLoggedIn)();
    }

    public function postLoginForm(): void {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            return;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $error_message = "Usuário ou senha incorretos";

        $user = $this->userRepository->findByUsername($username);
        
        if (!$user) {
            $this->getLoginForm($error_message);
            return;
        }

        if (! password_verify($password, $user->getPassword())) {
            $this->getLoginForm($error_message);
            return;
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['flash_success'] = "Usuário conectado com sucesso";

        ($this->onLoggedIn)();
    }

    public function postLogout(): void {
        unset($_SESSION['user_id']);
        $_SESSION['flash_alert'] = "Usuário desconectado com sucesso";
        
        ($this->onLoggedIn)();
    }

}
