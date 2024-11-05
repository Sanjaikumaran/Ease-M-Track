<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/classes/user.class.php';

$user = new user();

header('Content-Type: application/json');

if (isset($_POST['user']) && isset($_POST['psw'])) {
    $email = $_POST['user'];
    $password = $_POST['psw'];
    $data = $user->getData('Users', ['Email'], [$email]);

    if (count($data) > 0) {
        $hashedPassword = $data[0]['Password'];
        if (($password == $hashedPassword)) {
            $_SESSION['UserID'] = $data[0]['UserID'];


            echo json_encode([
                "status" => "success",
                "redirect" => "../my-transactions/"
            ]);
            exit;
        } else {

            echo json_encode([
                "status" => "error",
                "message" => "Invalid Username or Password"
            ]);
        }
    } else {

        echo json_encode([
            "status" => "error",
            "message" => "Invalid Username or Password"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Missing credentials"
    ]);
}
