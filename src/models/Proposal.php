<?php
namespace App\Model;

use Carbon\Carbon;
use App\Model\User;
use App\Model\Freelance;


class Proposal {

    public ?int $id;
    public string $message;
    public int $priceInCents;
    public Carbon $created_at;

    public User $user;
    public Freelance $freelance;

    public function __construct(?int $id, string $message, int $priceInCents, User $user, Freelance $freelance) {
        $this->id = $id;
        $this->message = $message;
        $this->priceInCents = $priceInCents;
        $this->created_at = Carbon::now();
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
        return $this->created_at;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getFreelance(): Freelance {
        return $this->freelance;
    }

}