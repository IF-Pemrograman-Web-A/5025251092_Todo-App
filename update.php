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

if (isset($_POST["completed"])) {
    $completed = (int)$_POST["completed"] === 1 ? 1 : 0;
    $stmt = $conn->prepare("UPDATE todos SET completed = ? WHERE id = ?");
    $stmt->bind_param("ii", $completed, $id);
    $stmt->execute();
    $stmt->close();
} else {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $dueDate = $_POST["due_date"] ?: null;
    $notification = $_POST["notification"] ?: null;

    if ($title === "" || $description === "") {
        exit("Title and description are required.");
    }

    $stmt = $conn->prepare(
        "UPDATE todos SET title = ?, description = ?, due_date = ?, notification = ? WHERE id = ?"
    );

    $stmt->bind_param(
        "ssssi",
        $title,
        $description,
        $dueDate,
        $notification,
        $id
    );

    $stmt->execute();
    $stmt->close();
}

header("Location: index.php?page=" . urlencode($page));
exit;
?>
