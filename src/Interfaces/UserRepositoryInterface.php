<?php

namespace App\Interfaces;

use App\Classes\User;

interface UserRepositoryInterface
{
    /**
     * Saves user name, user surname and user age in the database
     *
     * @param User $user
     * @return void
     */
    public function saveUser(User $user): void;

    /**
     * Gets users name, users surname and users age where user age over 18 from the database
     *
     * @return array
     */
    public function getUsers(): array;

    /**
     * Checks existing user in the database
     *
     * @param User $user
     * @return int
     */
    public function checkingExistingUser(User $user): int;
}