<?php

namespace App\Classes;

class User
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $surname;

    /**
     * @var int
     */
    private int $age;

    public function __construct($name, $surname, $age)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    public function nameValidation(): bool
    {
        return preg_match('/^[а-яёА-ЯЁ\s]+$/u', $this->name) && strlen($this->name) <= 35;
    }

    public function surnameValidation(): bool
    {
        return preg_match('/^[а-яёА-ЯЁ\s]+$/u', $this->surname) && strlen($this->surname) <= 35;
    }
}