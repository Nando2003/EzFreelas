<?php
namespace App\Model;

use Carbon\Carbon;


class User {
    
    private ?int $id;
    private string $name;
    private string $username;
    private string $email;
    private string $password;
    private Carbon $createdAt;
    
    public static function fromDatabase(int $id, string $name, string $username, string $email, string $hashedPassword, Carbon $createdAt): User {
        $user = new self($name, $username, $email, $hashedPassword);
        $user->setId($id);
        $user->password = $hashedPassword;
        $user->setCreatedAt($createdAt);
        return $user;
    }

    public function __construct(string $name, string $username, string $email, string $plainPassword) {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
        $this->createdAt = Carbon::now();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
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

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function setUsername(string $username) {
        $this->username = $username;
    }
}