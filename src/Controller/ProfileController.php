<?php
namespace App\Controller;

use PDO;
use App\Repository\UserRepository;
use App\Controller\BaseController;
use App\Controller\Handler404Controller;


class ProfileController extends BaseController {
    private UserRepository $userRepository;
    private Handler404Controller $handler404;

    public function __construct(PDO $pdo, Handler404Controller $handler404) {
        $this->userRepository = new UserRepository($pdo);
        $this->handler404 = $handler404;
    }

    public function get(): void {
        $userId = $this->getUserId();

        if ($userId == null) {
            $this->handler404->get();
            return;
        }

        $userObj = $this->userRepository->findById($userId);

        if ($userObj == null) {
            $this->handler404->get();
            return;
        }

        require __DIR__ . '/../View/profile/index.php';
    }

    public function post(): void {

        if ($_POST['action'] === 'update') {
            $userId = $this->getUserId();

            if ($userId == null) {
                http_response_code(403);
                return;
            }
            
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';

            if (empty($name) and empty($email) and empty($username)) {
                $this->get();
            }

            $userObj = $this->userRepository->findById($userId);

            if ($userObj == null) {
                http_response_code(404);
                return;
            } 

            if ($name and $name != $userObj->getName()) {
                $userObj->setName($name);
            }

            if ($email and $email != $userObj->getEmail()) {
                if ($this->userRepository->findByEmail($email) != null) {
                    $this->get('Email já existente');
                    return;
                }

                $userObj->setEmail($email);
            }

            if ($username and $username != $userObj->getUsername()) {
                if ($this->userRepository->findByUsername($username) != null) {
                    $this->get('Username já existente');
                    return;
                }

                $userObj->setUsername($username);
            }

            $this->userRepository->update($userObj);
            $_SESSION['flash_success'] = "Usuário atualizado com sucesso";

            http_response_code(200);
            $this->get();
            return;

        } elseif ($_POST['action'] === 'delete') {
            $userId = $this->getUserId();

            if ($userId == null) {
                http_response_code(403);
                return;
            }

            $userObj = $this->userRepository->findById($userId);

            if ($userId == null) {
                http_response_code(404);
                return;
            }
            
            $this->userRepository->remove($userObj);

            unset($_SESSION['user_id']);
            $_SESSION['flash_danger'] = "Usuário deletado com sucesso";

            $this->redirect('/home');
            http_response_code(200);
            return;
        }
    }
}