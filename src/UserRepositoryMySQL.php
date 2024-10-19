<?php

namespace App;

require_once __DIR__ . "/UserRepositoryInterface.php";

use PDO;

class UserRepositoryMySQL implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = getenv('DB_DATABASE');
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        $this->pdo = new PDO($dsn, $username, $password);
    }

    public function all(): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(User $user): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (firstname, lastname, email) VALUES (?, ?, ?)");
        $stmt->execute([$user->getFirstname(), $user->getLastname(), $user->getEmail()]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function find(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}