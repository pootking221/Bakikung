<?php

include "../sql.php";
$json = file_get_contents("php://input");
$data = json_decode($json, true);

$command = $data['command'] ?? '';
$id = $data['donate_id'] ?? null;
$title = $data['title'] ?? '';
$description = $data['description'] ?? '';
$location = $data['location'] ?? '';
$category_id = $data['category_id'] ?? null;
$available_until = $data['available_until'] ?? null;
$status = $data['status'] ?? null;

switch ($command) {
    case "select":
        $sql = "SELECT d.donate_id, d.title, d.description, d.picture_url, d.location, d.available_until, c.category_name, s.status_name, u.firstname ,u.lastname, u.tel, u.user_id FROM donations AS d
                INNER JOIN categories AS c ON d.category_id = c.category_id
                INNER JOIN users AS u ON u.user_id = d.user_id
                INNER JOIN status_request AS s ON s.status_id = d.status_item;";

        $result = $conn->query($sql);
        $data = [];
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode([
                'status' => '1',
                'message' => 'Data found',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => '0',
                'message' => 'not found data',
            ]);
        }


        $conn->close();

        break;
    case "selectwhere":

        $sql = "SELECT * FROM donations WHERE donate_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        // รันคำสั่ง
        $stmt->execute();
        // ดึงผลลัพธ์
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode([
                'status' => '1',
                'message' => 'Data found',
                'data' => $row
            ]);
        } else {
            echo json_encode([
                'status' => '0',
                'message' => 'not found data',
            ]);
        }
        $stmt->close();
        $conn->close();

        break;
    case "edit":
        $sql = "UPDATE donations SET title = ?, description = ?, location = ?, category_id = ?, available_until = ? WHERE donate_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssisi', $title, $description, $location, $category_id, $available_until, $id);


        if ($stmt->execute()) {
            echo json_encode([
                'status' => '1',
                'message' => 'Update success!!'
            ]);
        } else {
            echo json_encode([
                'status' => '0',
                'message' => $stmt->error
            ]);
        }
        $stmt->close();
        $conn->close();
        break;
    case "update_status":


        // select เช็คว่ามี id จริงไหม
        $check = $conn->prepare("SELECT donate_id FROM donations WHERE donate_id = ?");
        $check->bind_param("i", $id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            echo json_encode([
                "status" => "0",
                "message" => "ID not found"
            ]);
        } else {
                $sql = "UPDATE donations SET status_item = ? WHERE donate_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $status, $id);


                if ($stmt->execute()) {
                    echo json_encode([
                        'status' => '1',
                        'message' => 'Update Status ' . $status .  ' success!!'
                    ]);
                } else {
                    echo json_encode([
                        'status' => '0',
                        'message' => $stmt->error
                    ]);
                }
        }


        break;

    case "delete":
        $sql = "DELETE FROM donations WHERE donate_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => '1',
                'message' => 'Delete success!!'
            ]);
        } else {
            echo json_encode([
                'status' => '0',
                'message' => $stmt->error
            ]);
        }
        $stmt->close();
        $conn->close();

        break;
}
