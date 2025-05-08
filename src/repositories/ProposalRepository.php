<?php
namespace App\Repository;

use App\Model\Proposal;
use PDO;


class ProposalRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(Proposal $proposal): bool {
        $stmt = $this->pdo->prepare(
            'INSERT INTO proposals (message, price_in_cents, created_at, user_id, freelance_id) VALUES (:message, :price_in_cents, :created_at, :user_id, :freelance_id)'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        } 

        return $stmt->execute(
            [
                ':message' => $proposal->getMessage(),
                ':price_in_cents' => $proposal->getPriceInCents(),
                ':created_at' => $proposal->getCreatedAt()->toDateString(),
                ':user_id' => $proposal->getUser()->getId(),
                ':freelance_id' => $proposal->getFreelance()->getId()
            ]
        );
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

    /**
    * @return Proposal[]
    */
    public function findByFreelanceId(int $freelanceId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM proposals WHERE freelance_id = :freelance_id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        $stmt->execute([':freelance_id' => $freelanceId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $proposals = [];

        foreach ($rows as $row) {
            $proposals[] = $this->mapProposal($row);
        }

        return $proposals;
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

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM proposals WHERE id = :id'
        );

        if ($stmt == False) {
            throw new \Exception("Failed to prepare statement");
        }

        return $stmt->execute([':id' => $id]);
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
}