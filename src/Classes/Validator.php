<?php

namespace App\Classes;

/**
 * Uses for validating post inputs
 *
 * Class Validator
 * @package App\Classes
 */
class Validator
{
    private array $validator;

    public function __construct(array $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Sets rules for post inputs
     *
     * @return array
     */
    private function RulesForPostInputs(): array
    {
        return [
            'userName' => preg_match('/^([А-Я]{1}[а-яё]{1,34}|[A-Z][a-z]{1,34})$/u', $this->validator[0]),
            'userSurname' => preg_match('/^([А-Я]{1}[а-яё]{1,34}|[A-Z][a-z]{1,34})$/u', $this->validator[1]),
            'userAge' => ctype_digit($this->validator[2]) && $this->validator[2] > 0 && $this->validator[2] <= 100,
        ];
    }
    /**
     * Returns messages
     *
     * @return array
     */
    public function showErrorMessages(): array
    {
        $messages = [];
        foreach ($this->RulesForPostInputs() as $key => $value) {
            switch ($key) {
                case 'userName':
                    if (!$value) {
                        $messages[] = [
                            'status' => 'error',
                            'message' => 'Введите имя корректно (состоит только из букв до 35 символов)'
                        ];
                    }
                    break;
                case 'userSurname':
                    if (!$value) {
                        $messages[] = [
                            'status' => 'error',
                            'message' => 'Введите фамилию корректно (состоит только из букв до 35 символов)'
                        ];
                    }
                    break;
                case 'userAge':
                    if (!$value) {
                        $messages[] = [
                            'status' => 'error',
                            'message' => 'Введите возраст корректно (от 1 до 100)'
                        ];
                    }
                    break;
            }
        }
        return $messages;
    }
}