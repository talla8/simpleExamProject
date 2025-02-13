<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'Pass', FILTER_SANITIZE_STRING);

    // Database connection
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "student";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare 
    $stmt = $conn->prepare("SELECT login, password FROM studentlist WHERE login = ?");
    $stmt->bind_param("s", $userName);
    
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    } else {
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
           
            if (password_verify($pass, $user['password'])) { 
                $stmt->close();
                $conn->close();

                
                header("Location: /exam2.php?name=" . urlencode($user['name']));
                exit();
            } else {
                $errorMessage = "Invalid password.";
            }
        } else {
            $errorMessage = "User not found.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .edit {
            position: relative;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            background-color: white;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input:hover {
            background-color: #f0f0f0;
            border-color: #0056b3;
        }

        .error-message {
            position: absolute;
            top: -25px;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
            display: block;
        }
    </style>
</head>
<body>

<div class="edit">
    <?php if (isset($errorMessage)): ?>
        <div class="error-message">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <h2>Login</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="UserName" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="Pass" required>
        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>
