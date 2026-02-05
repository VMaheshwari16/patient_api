<?php
require_once __DIR__ . "/../config/database.php";

class Patient {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAll() {
        $res = $this->conn->query("SELECT * FROM patients");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $res = $this->conn->query("SELECT * FROM patients WHERE id=$id");
        return $res->fetch_assoc();
    }

    public function create($data) {
        $name  = $data['name'];
        $age   = $data['age'];
        $gender= $data['gender'];
        $phone = $data['phone'];

        return $this->conn->query(
            "INSERT INTO patients (name,age,gender,phone)
             VALUES ('$name',$age,'$gender','$phone')"
        );
    }

    public function update($id, $data) {
        return $this->conn->query(
            "UPDATE patients SET
             name='{$data['name']}',
             age={$data['age']},
             gender='{$data['gender']}',
             phone='{$data['phone']}'
             WHERE id=$id"
        );
    }

    public function delete($id) {
        return $this->conn->query("DELETE FROM patients WHERE id=$id");
    }
}
