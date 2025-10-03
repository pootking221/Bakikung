<?php

include "../sql.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$donate_id = $data['donate_id'] ?? null;
$requester_id = $data['requester_id'] ?? null;
$status_request = $data['status_request'] ?? null;
$requested_at = $data['requested_at'] ?? '';
$updated_at = $data['updated_at'] ?? '';
$decision_by = $data['decision_by'] ?? null;
$decision_note = $data['decision_note'] ?? '';
$message = $data['message'] ?? '';

$command = $data['command'];

switch ($command) {
    case "insert":
        $sql = "INSERT INTO requests ( donate_id, requester_id, message, status_request, requested_at, updated_at) VALUES (?,?,?,?,NOW(),NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            'iisi',
            $donate_id,
            $requester_id,
            $message,
            $status_request,
        );

        if ($stmt->execute()) {
            echo json_encode([
                'status' => '1',
                'mesage' => 'Insert comptete'
            ]);
        } else {

            echo json_encode([
                'status' => '1',
                'message' => $stmt->error
            ]);
        }


        break;
    case "select":
        $sql = "SELECT * FROM requests";
        $result = $conn->prepare($sql);

        if ($result->num_rows > 0) {
        } else {
            echo json_encode([
                'status' => '0',
                'message' => 'Not found data'
            ]);
        }




        break;
    case "select_where":



        break;
}
