<?php
// Database connection
$servername = "localhost";
$username = "root"; // change if you have another username
$password = ""; // change if you set a MySQL password
$dbname = "moviefinder_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_name = trim($_POST['member_name']);
    $member_email = trim($_POST['member_email']);
    $member_password = trim($_POST['member_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($member_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($member_password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM tblmembers WHERE member_email = ?");
    $checkEmail->bind_param("s", $member_email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists! Please try another one.'); window.history.back();</script>";
    } else {
        // Insert new member
        $stmt = $conn->prepare("INSERT INTO tblmembers (member_name, member_email, member_password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $member_name, $member_email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! You can now log in.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error: Something went wrong.'); window.history.back();</script>";
        }

        $stmt->close();
    }

    $checkEmail->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Movie Finder Registration</title>
  <link rel="stylesheet" href="register.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

:root {
  --bg-dark: #0b0c1b;
  --panel-dark: #1d1e2b;
  --accent: #ff4a33;
  --text-light: #d8d8d8;
  --shadow: 0 0 25px rgba(255, 74, 51, 0.3);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  height: 100vh;
  background: var(--bg-dark);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

h1 {
  text-align: center;
  color: var(--accent);
  font-size: 2.5rem;
  margin-bottom: 20px;
  text-shadow: 0 0 15px rgba(255, 74, 51, 0.5);
}

/* Container */
.container {
  width: 70%;
  max-width: 900px;
  background: var(--panel-dark);
  border-radius: 18px;
  display: flex;
  overflow: hidden;
  box-shadow: var(--shadow);
}

/* Left Form Panel */
.form-left {
  flex: 1;
  background: #1c1d2a;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 40px;
}

.form-left h2 {
  color: var(--accent);
  margin-bottom: 25px;
  font-size: 1.6rem;
  text-align: center;
}

.input-box {
  width: 100%;
  position: relative;
  margin-bottom: 20px;
}

.input-box input {
  width: 100%;
  padding: 12px 40px 12px 15px;
  border: 1px solid var(--accent);
  background: transparent;
  color: var(--text-light);
  border-radius: 8px;
  outline: none;
  font-size: 0.95rem;
}

.input-box i {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--accent);
  font-size: 18px;
}

button {
  width: 100%;
  padding: 12px;
  background: var(--accent);
  border: none;
  color: #fff;
  font-size: 1rem;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
}

button:hover {
  background: #ff6347;
  box-shadow: 0 0 15px rgba(255, 74, 51, 0.4);
}

.link-text {
  margin-top: 12px;
  font-size: 0.9rem;
  color: var(--text-light);
  text-align: center;
}

.link-text a {
  color: var(--accent);
  font-weight: 600;
  text-decoration: none;
}

.link-text a:hover {
  text-decoration: underline;
}

/* Right Welcome Panel */
.panel {
  flex: 1;
  background: linear-gradient(135deg, #1b1d2a, #242538);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: var(--text-light);
  text-align: center;
  padding: 40px;
}

.panel h2 {
  color: var(--accent);
  font-size: 1.6rem;
  margin-bottom: 10px;
}

.panel p {
  color: #999;
  font-size: 0.95rem;
  line-height: 1.6;
  max-width: 85%;
}
</style>
<body>

  <h1>MOVIE FINDER</h1>

  <div class="container">
    <div class="form-left">
      <form action="index.php" method="POST">
        <h2>Register</h2>
        <div class="input-box">
          <input type="text" name="member_name" placeholder="Full Name" required>
          <i class='bx bx-user'></i>
        </div>
        <div class="input-box">
          <input type="email" name="member_email" placeholder="Email Address" required>
          <i class='bx bx-envelope'></i>
        </div>
        <div class="input-box">
          <input type="password" name="member_password" placeholder="Password" required>
          <i class='bx bx-lock-alt'></i>
        </div>
        <div class="input-box">
          <input type="password" name="confirm_password" placeholder="Confirm Password" required>
          <i class='bx bx-lock'></i>
        </div>
        <button type="submit">Register</button>
        <div class="link-text">Already have an account? <a href="login.html">Login Now!</a></div>
      </form>
    </div>

    <div class="panel">
      <h2>Create Your Movie Profile</h2>
      <p>Join Movie Finder today and explore thousands of films!<br>Find your next favorite movie with ease.</p>
    </div>
  </div>

</body>
</html>
