<?php
require "config.php";
$page = $_GET["page"] ?? "personal";
if (!in_array($page, ["personal", "shared"], true)) {
    $page = "personal";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Todo List</h1>
    </header>

    <?php require "menu-bar.php"; ?>
    <?php require "content.php"; ?>

    <footer>
        <p>Dhia Hiroyuki Prawira</p>
    </footer>
</body>
</html>