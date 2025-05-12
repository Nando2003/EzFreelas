<?php
namespace App\Model;

use Carbon\Carbon;
use App\Model\User;


class Freelance {

    public ?int $id;
    public string $title;
    public string $description;
    public int $priceInCents;
    public Carbon $created_at;
    
    public User $user;

    public function __construct(string $title, string $description, int $priceInCents, User $user) {
        $this->title = $title;
        $this->description = $description;
        $this->priceInCents = $priceInCents;
        $this->created_at = Carbon::now();
        $this->user = $user;
    } 

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
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

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setCreatedAt(Carbon $created_at): void {
        $this->created_at = $created_at;
    }

}
