<?php
$targetFolder = "../datausers/images_donation/";
if (!file_exists($targetFolder)) {
    mkdir($targetFolder, 0777, true); // สร้าง folder ถ้ายังไม่มี
}

if (isset($_FILES["file_img"]) && $_FILES["file_img"]["error"] === UPLOAD_ERR_OK) {
    $originalName = basename($_FILES["file_img"]["name"]); // ชื่อไฟล์จาก JS (newFileName)
    $targetFile = $targetFolder . $originalName;

    if (move_uploaded_file($_FILES["file_img"]["tmp_name"], $targetFile)) {
        echo "File uploaded successfully as: " . $originalName;
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file selected or upload error.";
}
?>