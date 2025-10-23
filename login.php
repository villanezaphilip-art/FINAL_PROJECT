<?php
session_start();

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
    $email = trim($_POST['Username']);
    $password = trim($_POST['Password']);

    // Fetch user from DB
    $stmt = $conn->prepare("SELECT member_id, member_name, member_email, member_password FROM tblmembers WHERE member_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['member_password'])) {
            $_SESSION['member_id'] = $user['member_id'];
            $_SESSION['member_name'] = $user['member_name'];

            header("Location: homepage.php");
            exit();
        } else {
            echo "<script>
                    alert('Invalid password. Please try again.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('No account found with that email.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
