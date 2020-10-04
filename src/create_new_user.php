<?php

require_once '../vendor/autoload.php';

use App\Classes\User;
use App\Repositories\UserRepository;

if (isset($_POST['name'], $_POST['surname'], $_POST['age'])) {
    if ($_POST['name'] != '' && $_POST['surname'] != '' && $_POST['age'] != '') {
        if (filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT) && $_POST['age'] > 0) {
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
                'message' => 'Введите возраст корректно'
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
