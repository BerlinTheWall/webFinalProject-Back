<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Movie.php';

// Instance database and connect
$database = new Database();
$db = $database->connect();

// Instanciate Movie Object
$movie = new Movie($db);

// Get query from the URL
$movie->movieId = isset($_GET['movieId']) ? $_GET['movieId'] : die();

// Movie query
$result = $movie->delete();
