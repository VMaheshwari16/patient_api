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
                if (!$result) {
                    http_response_code(404);
                    Response::json(false, "Patient not found");
                }
                else{
                    Response::json(true, "Patients fetched", $result);
                }
                break;

            case 'POST':
                if (empty($data['name']) || empty($data['age']) || empty($data['gender']) || empty($data['phone']))
                {
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
                if (!$id) {
                    http_response_code(400);
                    Response::json(false, "Patient ID required");
                }

                if (empty($data['name']) || empty($data['age']) || empty($data['gender']) || empty($data['phone']))
                {
                    http_response_code(400);
                    Response::json(false, "All fields are required");
                }
                $this->patient->update($id, $data);
                Response::json(true, "Patient updated",$data);
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    Response::json(false, "Patient ID required");
                }
                $this->patient->delete($id);
                Response::json(true, "Patient deleted");
                break;
            
            case 'PATCH':
                if (!$id) {
                    http_response_code(400);
                    Response::json(false, "Patient ID required");
                }

                if (empty($data)) {
                    http_response_code(400);
                    Response::json(false, "No fields provided to update");
                }

                $this->patient->patch($id, $data);
                Response::json(true, "Patient updated partially");
                break;

            default:
                Response::json(false, "Method not allowed");
        }
    }
}
