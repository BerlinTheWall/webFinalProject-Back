<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Movie.php';

// Instance database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Movie Object
$movie = new Movie($db);

// Get Id from the URL
$movie->movieId = isset($_GET['movieId']) ? $_GET['movieId'] : die();

// Movie query
$result = $movie->readById();

// create array
$movie_arr = array(
    'movieId' => $movie->movieId,
    'title' => $movie->title,
    'description' => $movie->description,
    'year' => $movie->year,
    'imageSource' => $movie->imageSource,
);

// Make JSON
print_r(json_encode($movie_arr));
