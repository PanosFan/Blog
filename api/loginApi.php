<?php
session_start();

// import model
require_once './models/dbh.php';
require_once './models/loginModel.php';

// set required headers for all requests
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods');


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