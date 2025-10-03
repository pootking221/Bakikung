<?php
include "../sql.php";

session_start();

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$std_id = $data['std_id'];
$input_pass = $data['password'];


$sql = "SELECT * FROM users WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $std_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $row = $result->fetch_assoc();
    $hashed_pass_from_db = $row['password_hash'];

    if (password_verify($input_pass, $hashed_pass_from_db)) {



        $_SESSION['user'] = [
            'user_id' => $row['user_id'],
            'student_id' => $row['student_id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'role' => $row['role'],
            'email' => $row['email']
        ];



        echo json_encode([
            'status' => 'success',
            'message' => 'Login Success',
        ]);
    } else {
        echo json_encode(['status' => 'fail', 'message' => 'Invalid password']);
    }
} else {
    echo "User Not Found";
}
