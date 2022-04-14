<?php
session_start();

// import model
require_once './models/dbh.php';
require_once './models/signupModel.php';

// set required headers for all requests
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods');


    $data = json_decode(file_get_contents("php://input"));

    // Checking if any values are empty
    if (empty($data->name) || empty($data->surname) || empty($data->password) || empty($data->repeat_password) || empty($data->email)) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are mandatory']);
        die();
    }

    $name = $data->name;
    $surname = $data->surname;
    $email = $data->email;
    $password = $data->password;
    $repeat_password = $data->repeat_password;

    // CHeck if the email is a valid one
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Please enter a valid email']);
        die();
    }

    // Check if passwords match
    if ($password !== $repeat_password) {
        http_response_code(400);
        echo json_encode(['error' => 'Passwords needs to match']);
        die();
    }

    $signup = new Signup;
    $check = $signup->checkUser($email);

    // Check if that email has already been registered
    if ($check) {
        http_response_code(400);
        echo json_encode(['error' => 'A user with that email is registered already']);
        die();
    }

    // Registering the user
    $result = $signup->signupUser($name, $surname, $password, $email);

    // Final reponse
    if ($result->rowCount() > 0) {
        $getsession = $signup->getSessionID($email)->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $getsession['user_id'];
        http_response_code(200);
        echo json_encode(['success' => "User registered "]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Something went wrong']);
    }
}