<?php
include "../sql.php";

// รับ raw JSON จาก body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$std = $data['student_id'];
$fname = $data['firstname'];
$lname = $data['lastname'];
$email = $data['email'];
$hashpassword = password_hash($data['password'], PASSWORD_DEFAULT);
$tel = $data['tel'];
$role = "user";
$status_is_active = 1;


$sql = "INSERT INTO users 
        (student_id, firstname, lastname, email, password_hash, tel, role, is_active, create_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssi",
    $std,
    $fname,
    $lname,
    $email,
    $hashpassword,
    $tel,
    $role,
    $status_is_active
);

if ($stmt->execute()) {
    echo json_encode([
        'status' => '1',
        'message' => 'Insert Success',
    ]);
} else {

    echo json_encode([
        'status' => '1',
        'message' => $stmt->error
    ]);
}
