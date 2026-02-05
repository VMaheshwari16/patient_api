<?php
require_once __DIR__ . "/../models/Patient.php";
require_once __DIR__ . "/../helpers/Response.php";

class PatientController {

    private $patient;

    public function __construct() {
        $this->patient = new Patient();
    }

    public function handle($method, $id = null) {
        $data = json_decode(file_get_contents("php://input"), true);

        switch ($method) {

            case 'GET':
                $result = $id
                    ? $this->patient->getById($id)
                    : $this->patient->getAll();

                Response::json(true, "Patients fetched", $result);
                break;

            case 'POST':
                if (empty($data['name']) || empty($data['age'])) {
                    http_response_code(400);
                    Response::json(false, "Invalid input data");
                }
                else{
                $this->patient->create($data);
                http_response_code(201);
                Response::json(true, "Patient created",$data);
                }
                break;

            case 'PUT':
                $this->patient->update($id, $data);
                Response::json(true, "Patient updated");
                break;

            case 'DELETE':
                $this->patient->delete($id);
                Response::json(true, "Patient deleted");
                break;

            default:
                Response::json(false, "Method not allowed");
        }
    }
}
