<?php
session_start();

// import model
require_once './models/dbh.php';
require_once './models/postsModel.php';

// set required headers for all requests
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');


function extract_loop($result)
{
    $result_array = [];
    while ($result_row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($result_row);
        $item = [
            'post_id' => $post_id,
            'name' => $name,
            'title' => $title,
            'body' => $body
        ];
        array_push($result_array, $item);
    }
    echo json_encode($result_array);
}

function finalresponse($result)
{
    if ($result->rowCount() > 0) {
        extract_loop($result);
        http_response_code(200);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Something went wrong"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_GET['user'])) {
    $post = new Post;
    $result = $post->read();
    finalresponse($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user'])) {
    $user = $_GET['user'] ?? die();
    $post = new Post;
    $result = $post->read_by_user($user);
    if ($result->rowCount() > 0) {
        extract_loop($result);
        http_response_code(200);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "User was not found"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Credentials');


    $data = json_decode(file_get_contents("php://input"));

    $title = $data->title;
    $body = $data->body;

    $post = new Post;
    $result = $post->create($title, $body);

    finalresponse($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Credentials');

    $data = json_decode(file_get_contents("php://input"));
    $id = $_GET['id'] ?? die();
    $title = $data->title;
    $body = $data->body;

    $post = new Post;
    $result = $post->update($id, $title, $body);

    finalresponse($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'] ?? die();

    $post = new Post;
    $result = $post->delete($id);

    finalresponse($result);
}