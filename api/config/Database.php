<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "GVK#smum4";
    private $db   = "patients_db";

    public function connect() {
        $conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($conn->connect_error) {
            http_response_code(500);
            echo json_encode(["status" => false, "message" => "DB connection failed"]);
            exit;
        }

        return $conn;
    }
}
