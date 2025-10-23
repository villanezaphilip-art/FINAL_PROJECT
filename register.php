<?php

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "moviefinder_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['Name']);
    $email = trim($_POST['Username']);
    $password = trim($_POST['Password']);

    // Hash password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM tblmembers WHERE member_email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email already registered. Please log in instead.');
                window.location.href='login.php';
              </script>";
    } else {
        // Insert new member
        $stmt = $conn->prepare("INSERT INTO tblmembers (member_name, member_email, member_password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful! You can now log in.');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: Could not register user.');
                    window.history.back();
                  </script>";
        }

        $stmt->close();
    }
}
$conn->close();
?>
