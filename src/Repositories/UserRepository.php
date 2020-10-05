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
        $host = 'ec2-54-224-175-142.compute-1.amazonaws.com';
        $port = '5432';
        $dbname = 'dfapr7kgqlrfrn';
        $user = 'ijqawxufrdqfmu';
        $password = '6023523a8b3be63ad07224ff92e1321c9ff0d9dd384c59a4a5cad23b5bd539ca';
        $this->db = new \PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
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