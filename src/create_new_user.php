<?php

require_once '../vendor/autoload.php';

use App\Classes\User;
use App\Repositories\UserRepository;

if (isset($_POST['name'], $_POST['surname'], $_POST['age'])) {
    if ($_POST['name'] != '' && $_POST['surname'] != '' && $_POST['age'] != '') {
        if (preg_match('/^([А-ЯЁ]{1}[а-яё]{1,34})|([A-Z]{1}[a-z]{1,34})$/u', $_POST['name'])) {
            if (preg_match('/^([А-ЯЁ]{1}[а-яё]{1,34})|([A-Z]{1}[a-z]{1,34})$/u', $_POST['surname'])) {
                if (preg_match('#^[0-9]+$#', $_POST['age']) && $_POST['age'] > 0 && $_POST['age'] <= 100) {
                    $user = new User($_POST['name'], $_POST['surname'], $_POST['age']);
                    $userRepository = new UserRepository();
                    if (empty($userRepository->checkingExistingUser($user))) {
                        $userRepository->saveUser($user);
                        $jsonOutput = [
                            'code' => 200,
                            'message' => 'Данные нового пользователя добавлены в БД'
                        ];
                    } else {
                        $jsonOutput = [
                            'code' => 404,
                            'message' => 'Данные введенного пользователя уже есть в БД'
                        ];
                    }
                } else {
                    $jsonOutput = [
                        'code' => 404,
                        'message' => 'Введите возраст корректно (от 1 до 100)'
                    ];
                }
            } else {
                $jsonOutput = [
                    'code' => 404,
                    'message' => 'Введите фамилию корректно, начиная с заглавной буквы (до 35 символов)'
                ];
            }
        } else {
            $jsonOutput = [
                'code' => 404,
                'message' => 'Введите имя корректно, начиная с заглавной буквы (до 35 символов)'
            ];
        }
    } else {
        $jsonOutput = [
          'code' => 404,
          'message' => 'Заполните все поля'
        ];
    }
    header('Content-type: application/json');
    echo json_encode($jsonOutput);
}
