<?php

require_once '../vendor/autoload.php';

use App\Classes\User;
use App\Classes\Validator;
use App\Repositories\UserRepository;

if (isset($_POST['name'], $_POST['surname'], $_POST['age'])) {
    $validator = new Validator([
        $_POST['name'],
        $_POST['surname'],
        $_POST['age']
    ]);
    if (empty($validator->showErrorMessages())) {
        $user = new User($_POST['name'], $_POST['surname'], $_POST['age']);
        $userRepository = new UserRepository();
        if (empty($userRepository->checkingExistingUser($user))) {
            $userRepository->saveUser($user);
            $jsonOutput = [
                'status' => 'success',
                'message' => 'Данные нового пользователя добавлены в БД'
            ];
        } else {
            $jsonOutput = [
                'status' => 'error',
                'message' => 'Данный пользователь уже есть в БД'
            ];
        }
    } else {
        $jsonOutput = $validator->showErrorMessages();
    }
    header('Content-type: application/json');
    echo json_encode($jsonOutput);
}
