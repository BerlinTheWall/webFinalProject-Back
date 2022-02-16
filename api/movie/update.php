<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Movie.php';

// Instance database and connect
$database = new Database();
$db = $database->connect();

// Instanciate Movie Object
$movie = new Movie($db);

// Get raw posted data
$data = json_decode((file_get_contents("php://input")));

$movie->movieId = $data->movieId;
$movie->title = $data->title;
$movie->description = $data->description;
$movie->year = intval($data->year);
$movie->imageSource = $data->imageSource;

// Create the post
if (isset($movie->title) && isset($movie->description) && isset($movie->year) && isset($movie->imageSource) && $movie->edit()) {
    echo json_encode(array('message' => 'The movie has been updated.'));
} else {
    echo json_encode(array('message' => 'Error in updating the movie.'));
}
