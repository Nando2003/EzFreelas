<?php
namespace App\Model;

use Carbon\Carbon;


class User {
    
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private Carbon $createdAt;
    
    public function __construct(string $username, string $email, string $plainPassword) {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
        $this->createdAt = Carbon::now();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getCreatedAt(): Carbon {
        return $this->createdAt;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setCreatedAt(Carbon $createdAt): void {
        $this->createdAt = $createdAt;
    }

}