<?php
namespace App\Repository;

use Carbon\Carbon; 
use App\Model\User;
use PDO;


class UserRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(User $user): bool {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, username, email, password, created_at) VALUES (:name, :username, :email, :password, :created_at)'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        } 

        return $stmt->execute(
            [
                ':name' => $user->getName(),
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':created_at' => $user->getCreatedAt()->toDateString()
            ]
        );

    }

    public function findById(int $id): ?User {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE id = :id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapUser($row);
        }
        return null;
    }

    public function findByUsername(string $username): ?User {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE username = :username'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapUser($row);
        }
        return null;
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapUser($row);
        }
        return null;
    }

    private function mapUser(array $row): User {
        $user = User::fromDatabase(
            $row['id'],
            $row['name'],
            $row['username'],
            $row['email'],
            $row['password'],
            Carbon::parse($row['created_at'])
        );

        return $user;
    }

}
