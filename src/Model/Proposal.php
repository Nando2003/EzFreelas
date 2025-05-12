<?php
namespace App\Model;

use Carbon\Carbon;
use App\Model\User;
use App\Model\Freelance;


class Proposal {

    private ?int $id;
    private string $message;
    private int $priceInCents;
    private Carbon $createdAt;
    private User $user;
    private Freelance $freelance;

    public function __construct(string $message, int $priceInCents, User $user, Freelance $freelance) {
        $this->message = $message;
        $this->priceInCents = $priceInCents;
        $this->createdAt = Carbon::now();
        $this->user = $user;
        $this->freelance = $freelance;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function getPriceInCents(): int {
        return $this->priceInCents;
    }

    public function getCreatedAt(): Carbon {
        return $this->createdAt;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getFreelance(): Freelance {
        return $this->freelance;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setCreatedAt(Carbon $createdAt): void {
        $this->createdAt = $createdAt;
    }

}