<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'basic-php-crud';
    private $username = 'root';
    private $password = '';
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throws exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // fetches an associative array
    ];
    private $conn; // connection variable

    // Constructor: function that runs automatically when an object is created
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, $this->options);
            // new PDO("mysql:host=localhost;dbname=basic-php-crud, root, ''"); This is the same as the line above, shown for better understanding
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function select($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(); // fetchAll() returns an array of all rows
    }

    public function create($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $this->conn->lastInsertId(); // returns the last inserted ID
    }

    public function update($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount(); // returns the number of affected rows (not used as of now but can be used for error handling)
    }

    public function delete($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount(); // returns the number of affected rows (not used as of now but can be used for error handling)
    }
}