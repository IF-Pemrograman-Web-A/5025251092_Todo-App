<?php
$host = "localhost";
$dbname = "todo_app";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
