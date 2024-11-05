<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/classes/user.class.php';

$user = new user();
header('Content-Type: application/json');

if (
    isset($_POST['SNo']) &&
    isset($_POST['Amount']) &&
    isset($_POST['TransactionType']) &&
    isset($_POST['GivenTo']) &&
    isset($_POST['Remark'])
) {
    $SNo = $_POST['SNo'];
    $Amount = $_POST['Amount'];
    $TransactionType = $_POST['TransactionType'];
    $GivenTo = $_POST['GivenTo'];
    $Remark = $_POST['Remark'];
    $userID = $_SESSION['UserID'];

    try {
        $result = $user->updateData(
            'Transactions',
            ['Amount', 'TransactionType', 'GivenTo', 'Remark'], // No need to include 'SNo' here as it's part of the WHERE clause
            [$Amount, $TransactionType, $GivenTo, $Remark], // Exclude SNo here
            "SNo = '$SNo' AND UserID = '$userID'"
        );
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
    if ($result) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Transaction updated successfully"
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Failed to update transaction"
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing or incomplete data"
    ]);
}
