<?php
include "../sql.php";
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$title = $data['title'];
$description = $data['description'];
$location = $data['location'];
$picture_url = $data['picture_url'];
$status_item = "10001";
$user_id = $data['user_id'];
$category_id = $data['category_id'];
$available_until = $data['available_until'];


$sql = "INSERT INTO donations (title, description, location, picture_url, status_item, availble_from, create_at, user_id, category_id, available_until) VALUES (?,?,?,?,?,NOW(),NOW(),?,?,?)";
$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssiiis",
    $title,
    $description,
    $location,
    $picture_url,
    $status_item,
    $user_id,
    $category_id,
    $available_until
);

if ($stmt->execute()) {

    echo json_encode([
        'status' => 'success',
        'message' => 'Insert Success',
    ]);
} else {
    echo json_encode(['status' => 'fail', 'message' => 'Invalid']);
}
