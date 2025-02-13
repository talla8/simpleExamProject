<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "student";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users' passwords
$result = $conn->query("SELECT login, password FROM studentlist");

while ($row = $result->fetch_assoc()) {
    $hashedPassword = password_hash($row['password'], PASSWORD_DEFAULT);

    // Update each password with its hashed version
    $stmt = $conn->prepare("UPDATE studentlist SET password = ? WHERE login = ?");
    $stmt->bind_param("ss", $hashedPassword, $row['login']);
    $stmt->execute();
}

echo "Passwords have been successfully hashed!";

$conn->close();
?>
