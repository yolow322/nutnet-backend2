<?php

require_once '../vendor/autoload.php';

use App\Repositories\UserRepository;

$googleClient = new Google_Client();
$googleClient->setApplicationName('nutnet-backend2');
$googleClient->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$googleClient->setAccessType('offline');
try {
    $googleClient->setAuthConfig(__DIR__ . '/nutnet-backend2.json');
} catch (Google_Exception $e) {
    $jsonOutput = [
        'code' => 404,
        'message' => $e->getMessage(), $e->getCode()
    ];
}
$googleService = new Google_Service_Sheets($googleClient);
$spreadsheetId = '14YUybqYV_bVr7hu7LW1J0JAi-DnE-IALOadtzjHCs_g';
$range = 'List1';
$response = $googleService->spreadsheets_values->get(
    $spreadsheetId,
    $range
);
$insertValues = [];
$userRepository = new UserRepository();
if (empty($response->getValues())) {
    foreach ($userRepository->getUsers() as $row) {
        $insertValues[] = [
            $row[0], $row[1], $row[2], $row[3]
        ];
    }
} else {
    foreach ($userRepository->getUsers() as $key => $row) {
        if (in_array($row, $response->getValues())) {
            unset($userRepository->getUsers()[$key]);
        } else {
            $insertValues[] = [
                $row[0], $row[1], $row[2], $row[3]
            ];
        }
    }
}
if (empty($insertValues)) {
    $jsonOutput = [
        'code' => 404,
        'message' => 'В данный момент все записи из БД уже есть в таблице'
    ];
} else {
    $postBody = new Google_Service_Sheets_ValueRange([
        'values' => $insertValues
    ]);
    $optParams = [
        'valueInputOption' => 'RAW'
    ];
    $googleService->spreadsheets_values->append(
        $spreadsheetId,
        $range,
        $postBody,
        $optParams
    );
    $jsonOutput = [
        'code' => 200,
        'message' => 'Данные из БД успешно добавлены в google таблицу'
    ];
}
header('Content-type: application/json');
echo json_encode($jsonOutput);
