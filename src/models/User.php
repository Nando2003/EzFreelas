<?php
namespace App\Model;

use Carbon\Carbon;


class User {
    
    public ?int $id;
    public string $username;
    public string $email;
    public string $password;
    public Carbon $created_at;
    
    public function __construct(?int $id, string $username, string $email, string $password) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->created_at = Carbon::now();
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

    public function getCreatedAt(): Carbon {
        return $this->created_at;
    }

}