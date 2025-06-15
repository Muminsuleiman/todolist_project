<?php
$host = 'localhost';
$dbname = 'todoapp';
$username = 'root'; // default XAMPP user
$password = '';     // default XAMPP password is empty

$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception("Connection failed: " . $e->getMessage());
}
?>