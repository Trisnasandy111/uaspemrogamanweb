<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uefa_euro_2024";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
