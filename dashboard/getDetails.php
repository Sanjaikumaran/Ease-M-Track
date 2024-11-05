<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/classes/user.class.php';

$user = new user();

header('Content-Type: application/json');

try {
    // Check if UserID is set in session
    if (!isset($_SESSION['UserID'])) {
        throw new Exception("User not authenticated");
    }

    $result = $user->getData('Transactions', ['UserID'], [$_SESSION['UserID']]);

    // Check if result is not empty
    if (!empty($result)) {
        foreach ($result as $key => $value) {
            // Format Amount if it exists and is numeric
            if (isset($result[$key]['Amount']) && is_numeric($result[$key]['Amount'])) {
                $result[$key]['Amount'] = number_format($result[$key]['Amount']);
            }
            unset($result[$key]['UserID']); // Correctly delete UserID from result
        }
    }

    echo json_encode(["data" => $result, "status" => "success", "message" => "Transactions fetched successfully"]);
} catch (\Throwable $th) {
    error_log($th->getMessage());

    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch transactions"
    ]);
}
