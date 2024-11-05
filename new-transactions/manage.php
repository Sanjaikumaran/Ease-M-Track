<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/classes/user.class.php';

$user = new user();
header('Content-Type: application/json');

if (
    isset($_POST['amount'][0]) &&
    isset($_POST['transactionType'][0]) &&
    isset($_POST['givenTo'][0]) &&
    isset($_POST['remarks'][0])
) {
    $amount = $_POST['amount'];
    $transactionType = $_POST['transactionType'];
    $givenTo = $_POST['givenTo'];
    $remarks = $_POST['remarks'];
    $userID = $_SESSION['UserID'];

    $errorKeys = [];

    foreach ($amount as $key => $value) {

        if (!is_numeric($amount[$key]) || $amount[$key] <= 0 || empty($transactionType[$key]) || empty($givenTo[$key])) {
            $errorKeys[] = $key;
            continue;
        }


        $result = $user->insertData(
            'Transactions',
            ['UserID', 'Amount', 'TransactionType', 'GivenTo', 'Remark'],
            [$userID, $amount[$key], $transactionType[$key], $givenTo[$key], $remarks[$key]]
        );


        if (!$result) {
            $errorKeys[] = $key;
        }
    }


    if (count($errorKeys) === 0) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "All transactions successfully added"
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Failed to add transactions for entries: " . implode(", ", $errorKeys),
            "failedEntries" => $errorKeys
        ]);
    }
} else {

    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing or incomplete data"
    ]);
}
