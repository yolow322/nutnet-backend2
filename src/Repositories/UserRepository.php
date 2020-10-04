<?php

namespace App\Repositories;

use App\Classes\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var \PDO
     */
    private \PDO $db;

    public function __construct()
    {
        $this->db = new \PDO('pgsql:host=localhost;port=5432;dbname=postgres;user=postgres;password=111');
    }

    /**
     * {@inheritDoc}
     */
    public function saveUser(User $user): void
    {
        $stm = $this->db->prepare('INSERT INTO USERS (name, surname, age) VALUES (?, ?, ?)');
        $stm->execute([
            $user->getName(),
            $user->getSurname(),
            $user->getAge()
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers(): array
    {
        $stm = $this->db->query('SELECT * FROM USERS WHERE age > 18');
        return $stm->fetchAll(\PDO::FETCH_NUM);
    }

    /**
     * {@inheritdoc}
     */
    public function checkingExistingUser(User $user): int
    {
        $stm = $this->db->prepare('SELECT COUNT(*) FROM USERS WHERE name = ? AND surname = ? AND age = ?');
        $stm->execute([
            $user->getName(),
            $user->getSurname(),
            $user->getAge()
        ]);
        return $stm->fetchColumn();
    }
}