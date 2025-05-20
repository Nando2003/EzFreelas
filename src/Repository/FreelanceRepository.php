<?php
namespace App\Repository;

use PDO;
use Carbon\Carbon;
use App\Model\Freelance;
use App\Repository\UserRepository;
use App\Repository\RepositoryInterface;


class FreelanceRepository implements RepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
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
        $freelance->setCreatedAt(Carbon::parse($row['created_at']));
        return $freelance;
    }   

    public function add(object $model): Freelance {
        /**
         * @var Freelance $model
         */
        $freelance = $model;

        $stmt = $this->pdo->prepare(
            'INSERT INTO freelances (title, description, price_in_cents, created_at, user_id) 
             VALUES (:title, :description, :price_in_cents, :created_at, :user_id)'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        } 

        $stmt->execute([
            ':title' => $freelance->getTitle(),
            ':description' => $freelance->getDescription(),
            ':price_in_cents' => $freelance->getPriceInCents(),
            ':created_at' => $freelance->getCreatedAt()->toDateTimeString(),
            ':user_id' => $freelance->getUser()->getId()
        ]);

        $newId = (int) $this->pdo->lastInsertId();
        $freelance->setId($newId);

        return $freelance;
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
    public function findAllPaginated(int $limit, int $offset, ?int $user_id = null) {
        if (!$user_id) {
            $stmt = $this->pdo->prepare(
                'SELECT * 
                FROM freelances 
                ORDER BY created_at DESC 
                LIMIT :limit OFFSET :offset'
            );
        } else {
            $stmt = $this->pdo->prepare(
                'SELECT * 
                FROM freelances 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT :limit OFFSET :offset'
            );
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        }
        

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $freelances = [];
        
        foreach ($rows as $row) {
            $freelances[] = $this->mapFreelance($row);
        }

        return $freelances;
    }

    public function countAll(): int {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM freelances');
        return (int) $stmt->fetchColumn();
    }

    public function remove(object $model): void {
        /**
         * @var Freelance $model
         */
        $freelance = $model;

        $stmt = $this->pdo->prepare(
            'DELETE FROM freelances WHERE id = :id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':id' => $freelance->getId()]);
    }

    public function update(object $model): Freelance {
        /**
         * @var Freelance $model
         */
        $freelance = $model;

        $stmt = $this->pdo->prepare(
            'UPDATE freelances
                SET title            = :title,
                    description      = :description,
                    price_in_cents   = :price_in_cents,
                    user_id          = :user_id
              WHERE id               = :id'
        );

        if (! $stmt) {
            throw new \Exception("Failed to prepare UPDATE statement");
        }

        $stmt->execute([
            ':title'          => $freelance->getTitle(),
            ':description'    => $freelance->getDescription(),
            ':price_in_cents' => $freelance->getPriceInCents(),
            ':user_id'        => $freelance->getUser()->getId(),
            ':id'             => $freelance->getId(),
        ]);

        return $freelance;
    }

}
