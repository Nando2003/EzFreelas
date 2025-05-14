<?php
namespace App\Repository;

use PDO;
use App\Model\Proposal;
use App\Repository\RepositoryInterface;

class ProposalRepository implements RepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    private function mapProposal(array $row): Proposal {
        $userRepo = new UserRepository($this->pdo);
        $user = $userRepo->findById($row['user_id']);

        if (!$user) {
            throw new \Exception("Usuário não encontrado para freelance ID {$row['id']}");
        }

        $freelanceRepo = new FreelanceRepository($this->pdo);
        $freelance = $freelanceRepo->findById($row['freelance_id']);

        if (!$freelance) {
            throw new \Exception("Freelance não encontrado para proposta ID {$row['id']}");
        }

        $proposal = new Proposal(
            $row['message'],
            (int)$row['price_in_cents'],
            $user,
            $freelance
        );

        $proposal->setId((int)$row['id']);
        $proposal->setCreatedAt(new \DateTime($row['created_at']));
        return $proposal;
    }
    
    public function add(object $model): Proposal {
        /** 
         * @var Proposal $model
         */
        $proposal = $model;
        
        $stmt = $this->pdo->prepare(
            'INSERT INTO proposals (message, price_in_cents, created_at, user_id, freelance_id) VALUES (:message, :price_in_cents, :created_at, :user_id, :freelance_id)'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        } 

        $stmt->execute([
            ':message' => $proposal->getMessage(),
            ':price_in_cents' => $proposal->getPriceInCents(),
            ':created_at' => $proposal->getCreatedAt()->toDateString(),
            ':user_id' => $proposal->getUser()->getId(),
            ':freelance_id' => $proposal->getFreelance()->getId()
        ]);

        $newId = (int) $this->pdo->lastInsertId();
        $proposal->setId($newId);

        return $proposal;
    }

    public function findById(int $id): ?Proposal {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM proposals WHERE id = :id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapProposal($row);
        }
        return null;
    }

    public function remove(object $model): void {
        /** 
         * @var Proposal $model
         */
        $proposal = $model;

        $stmt = $this->pdo->prepare(
            'DELETE FROM proposals WHERE id = :id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':id' => $proposal->getId()]);
    }

    public function update(object $model): Proposal {
        /** 
         * @var Proposal $model
         */
        $proposal = $model;

        $stmt = $this->pdo->prepare(
            'UPDATE proposals
                SET message         = :message,
                    price_in_cents  = :price_in_cents,
                    user_id         = :user_id,
                    freelance_id    = :freelance_id
            WHERE id = :id'
        );
        
        $stmt->execute([
            ':message'        => $proposal->getMessage(),
            ':price_in_cents' => $proposal->getPriceInCents(),
            ':user_id'        => $proposal->getUser()->getId(),
            ':freelance_id'   => $proposal->getFreelance()->getId(),
            ':id'             => $proposal->getId(),
        ]);

        return $proposal;
    }

    /**
    * @return Proposal[]
    */
    public function findByFreelanceIdPaginated(int $freelanceId, int $limit, int $offset): array {
        $stmt = $this->pdo->prepare('
            SELECT * FROM proposals
            WHERE freelance_id = :freelance_id
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset
        ');

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->bindValue(':freelance_id', $freelanceId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $proposals = [];

        foreach ($rows as $row) {
            $proposals[] = $this->mapProposal($row);
        }

        return $proposals;
    }

    public function countByFreelanceId(int $freelanceId): int {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM proposals WHERE freelance_id = :freelance_id');
        $stmt->execute([':freelance_id' => $freelanceId]);
        return (int)$stmt->fetchColumn();
    }

    /**
    * @return Proposal[]
    */
    public function findByUserId(int $userId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM proposals WHERE user_id = :user_id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':user_id' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $proposals = [];

        foreach ($rows as $row) {
            $proposals[] = $this->mapProposal($row);
        }

        return $proposals;
    }
}
