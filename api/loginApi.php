<?php
session_start();

// import model
require_once './models/dbh.php';
require_once './models/loginModel.php';

// set required headers for all requests
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {



    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->email) || empty($data->password)) {
        http_response_code(400);
        echo json_encode(['error' => 'Fields are required']);
        die();
    }

    $email = $data->email;
    $password = $data->password;

    $login = new Login;

    $result = $login->loginUser($email, $password);
    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $row['password'])) {
            http_response_code(200);
            $_SESSION['user_id'] = $row['user_id'];
            echo json_encode(['success' => 'You are logged in']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Wrong credentials']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'User not found']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_SESSION['user_id'])) {
        session_unset();
        session_destroy();
        http_response_code(200);
        echo json_encode(['success' => 'You logged out']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'You were not logged in']);
    }
}