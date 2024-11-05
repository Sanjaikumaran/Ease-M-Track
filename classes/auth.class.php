<?php
session_start();

header('Content-Type: application/json');

$response = ['sessionActive' => false];

if (isset($_SESSION['UserID'])) {
    $response['sessionActive'] = true;
    $response['data'] = $_SESSION['UserID']; // You can return specific session data if needed
}

echo json_encode($response);
