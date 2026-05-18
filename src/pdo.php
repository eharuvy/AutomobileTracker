<?php
// src/pdo.php - use environment variables for configuration

// Optionally load .env via vlucas/phpdotenv if installed (composer)
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
	require_once __DIR__ . '/../vendor/autoload.php';
	if (class_exists('Dotenv\\Dotenv')) {
		try {
			$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
			$dotenv->safeLoad();
		} catch (Exception $e) {
			// ignore dotenv errors; fallback to getenv()
		}
	}
}

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
