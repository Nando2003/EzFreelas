<?php
declare(strict_types=1);

namespace App\Controller;


abstract class BaseController {

    abstract public function get(): void;

    public function post(): void {
        http_response_code(405);
    }

    public static function redirect(string $location): void {
        $location_header = sprintf('Location: %s', $location); 
        header($location_header);
        exit;
    }

    public static function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }
}