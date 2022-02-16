<?php
class Movie
{
    // DB Stuff
    private $conn;
    private $table = 'movie';

    // Movie Properties
    public $searchQuery;
    public $movieId;
    public $title;
    public $description;
    public $year;
    public $imageSource;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Movies
    public function read()
    {
        // create query
        $query = 'SELECT * from ' . $this->table;
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Movie by Id
    public function readById()
    {
        // create query
        $query = 'SELECT * from ' . $this->table . ' where movieId=?';
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->movieId);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->movieId = $row['movieId'];
        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->year = $row['year'];
        $this->imageSource = $row['imageSource'];

        return $stmt;
    }

    // Create Movie
    public function create()
    {
        // create query
        $query = 'insert into ' . $this->table . ' (title,description,year,imageSource) values(:title,:description,:year,:imageSource);';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data (for security)
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->imageSource = htmlspecialchars(strip_tags($this->imageSource));

        // Bind the data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':imageSource', $this->imageSource);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            echo "error";
            return false;
        }
    }

    // Search Movies
    public function search()
    {
        // create query
        $query = 'select * from ' . $this->table . ' where title=:title or year=:year';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind the data
        if (isset($this->searchQuery)) {
            $stmt->bindParam(':title', $this->searchQuery);
            $stmt->bindParam(':year', $this->searchQuery);
        } else {
            $query = 'select * from ' . $this->table;
        }

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Delete Movies
    public function delete()
    {
        // create query
        $query = 'delete from ' . $this->table . ' where movieId=:id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind the data
        $stmt->bindParam(':id', $this->movieId);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Edit Movie
    public function edit()
    {
        // create query
        $query = 'update ' . $this->table . ' set title=:title, description=:description, year=:year, imageSource=:imageSource where movieId=:movieId;';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data (for security)
        $this->movieId = htmlspecialchars(strip_tags($this->movieId));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->imageSource = htmlspecialchars(strip_tags($this->imageSource));

        // Bind the data
        $stmt->bindParam(':movieId', $this->movieId);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':imageSource', $this->imageSource);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            echo "error";
            return false;
        }
    }
}
