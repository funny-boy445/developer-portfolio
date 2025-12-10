<?php
require_once 'config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $conn->exec("USE " . DB_NAME);

    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    $conn->exec($sql);

    echo "<h1 style='color: #dc2626; text-align: center; margin-top: 50px;'>✅ Setup Completed Successfully!</h1>";
    echo "<p style='text-align: center;'><a href='main.php' style='color: #dc2626; text-decoration: none; font-weight: bold;'>Go to Portfolio</a></p>";

} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>