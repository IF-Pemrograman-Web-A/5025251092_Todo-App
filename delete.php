<?php
require "config.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$page = $_POST["page"] ?? "personal";
if (!in_array($page, ["personal", "shared"], true)) {
    $page = "personal";
}

if (!$id) {
    exit("Invalid todo ID.");
}

$stmt = $conn->prepare("SELECT image FROM todos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$todo = $result->fetch_assoc();

$stmt->close();

$stmt = $conn->prepare("DELETE FROM todos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

if ($todo && $todo["image"] && is_file("uploads/" . $todo["image"])) {
    unlink("uploads/" . $todo["image"]);
}

header("Location: index.php?page=" . urlencode($page));
exit;
?>
