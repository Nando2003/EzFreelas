<?php
namespace App\Repository;

use App\Repository\UserRepository;
use App\Model\Freelance;
use PDO;


class FreelanceRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(Freelance $freelance): bool {
        $stmt = $this->pdo->prepare(
            'INSERT INTO freelances (title, description, price_in_cents, created_at, user_id) VALUES (:title, :description, :price_in_cents, :created_at, :user_id)'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        } 

        return $stmt->execute(
            [
                ':title' => $freelance->getTitle(),
                ':description' => $freelance->getDescription(),
                ':price_in_cents' => $freelance->getPriceInCents(),
                ':created_at' => $freelance->getCreatedAt()->toDateString(),
                ':user_id' => $freelance->getUser()->getId()
            ]
        );
    }

    public function findById(int $id): ?Freelance {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM freelances WHERE id = :id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapFreelance($row);
        }
        return null;
    }

    /**
    * @return Freelance[]
    */
    public function findByUserId(int $userId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM freelances WHERE user_id = :user_id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':user_id' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $freelances = [];

        foreach ($rows as $row) {
            $freelances[] = $this->mapFreelance($row);
        }

        return $freelances;
    }

    /**
    * @return Freelance[]
    */
    public function findAll(): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM freelances'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $freelances = [];

        foreach ($rows as $row) {
            $freelances[] = $this->mapFreelance($row);
        }

        return $freelances;
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM freelances WHERE id = :id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        return $stmt->execute([':id' => $id]);
    }

    private function mapFreelance(array $row): Freelance {
        $userRepo = new UserRepository($this->pdo);
        $user = $userRepo->findById($row['user_id']);
    
        if (!$user) {
            throw new \Exception("Usuário não encontrado para freelance ID {$row['id']}");
        }
    
        $freelance = new Freelance(
            $row['title'],
            $row['description'],
            (int)$row['price_in_cents'],
            $user
        );

        $freelance->setId((int)$row['id']);
        $freelance->setCreatedAt(new \DateTime($row['created_at']));
        return $freelance;
    }    

}