<?php
// src/pdo.php - use environment variables for configuration

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: 'misc';
$user = getenv('DB_USER') ?: 'fred';
$password = getenv('DB_PASSWORD') ?: 'zap';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}
