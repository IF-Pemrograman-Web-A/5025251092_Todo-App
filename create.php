<?php
require "config.php";

$page = $_POST["page"] ?? "personal";
if (!in_array($page, ["personal", "shared"], true)) {
    $page = "personal";
}

$title = trim($_POST["title"] ?? "");
$description = trim($_POST["description"] ?? "");
$dueDate = $_POST["due_date"] ?: null;
$notification = $_POST["notification"] ?: null;
$imageName = null;

if ($title === "" || $description === "") {
    exit("Title and description are required. Go back and try again.");
}

if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        exit("Image upload failed.");
    }

    $allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png", "image/gif" => "gif", "image/webp" => "webp"];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $_FILES["image"]["tmp_name"]);
    finfo_close($fileInfo);

    if (!isset($allowedTypes[$mimeType])) {
        exit("Please upload a JPG, PNG, GIF, or WEBP image.");
    }

    if ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
        exit("Image must be 5 MB or smaller.");
    }

    if (!is_dir("uploads")) {
        mkdir("uploads", 0755, true);
    }

    $imageName = bin2hex(random_bytes(16)) . "." . $allowedTypes[$mimeType];
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $imageName)) {
        exit("Could not save the uploaded image.");
    }
}

$stmt = $conn->prepare(
    "INSERT INTO todos (title, description, due_date, image, notification, completed, todo_type)
     VALUES (?, ?, ?, ?, ?, 0, ?)"
);

$stmt->bind_param(
    "ssssss",
    $title,
    $description,
    $dueDate,
    $imageName,
    $notification,
    $page
);

$stmt->execute();
$stmt->close();

header("Location: index.php?page=" . urlencode($page));
exit;
?>
