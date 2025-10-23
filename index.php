<?php
  include("login.php");
  include("register.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Finder - Auth</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <link rel="stylesheet" href="huhu.css/loginpage.css"> <!-- Assuming this is still relevant; update if needed -->
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  body {
    background: #1a1a2e; /* Dark blue-gray for cinematic feel */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    position: relative;
    color: #ffffff; /* White text for contrast */
  }

  /* App Title */
  .app-title {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 34px;
    font-weight: 700;
    color: #e74c3c; /* Red accent for emphasis */
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
    z-index: 20;
  }

  /* Container */
  .container {
    width: 800px;
    height: 480px;
    background: #2c2c3e; /* Darker background for theme consistency */
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(231, 76, 60, 0.25); /* Red-tinted shadow */
    overflow: hidden;
    display: flex;
    position: relative;
  }

  /* Gradient Overlay (Subtle for theme) */
  .container::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    background: linear-gradient(135deg, #e74c3c 0%, #8FB7FF 100%); /* Red gradient overlay for cinematic effect */
    opacity: 0.1;
    pointer-events: none;
  }

  /* Panels */
  .panel {
    width: 50%;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #ffffff; /* White text */
  }
  .panel h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #e74c3c; /* Red for headings */
  }
  .panel p {
    font-size: 13px;
    color: #6c757d; /* Muted gray for secondary text */
    margin-bottom: 20px;
    line-height: 1.4;
  }

  /* Form Panels */
  .form-left, .form-right {
    position: absolute;
    top: 0;
    width: 50%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: #2c2c3e; /* Dark background */
    z-index: 15;
    transition: 0.6s ease-in-out;
  }

  .form-left { left: 0; }
  .form-right { right: -50%; opacity: 0; }

  .container.register-mode .form-left {
    left: -50%; opacity: 0;
  }
  .container.register-mode .form-right {
    right: 0; opacity: 1;
  }

  /* Inputs */
  .input-box {
    position: relative;
    margin-bottom: 15px;
    width: 100%;
    max-width: 260px;
  }
  .input-box input {
    width: 100%;
    padding: 10px 34px 10px 12px;
    border: 1px solid #e74c3c; /* Red border for accent */
    border-radius: 8px;
    outline: none;
    font-size: 13px;
    background: #1a1a2e; /* Dark background */
    color: #ffffff; /* White text */
  }
  .input-box input:focus {
    border-color: #c0392b; /* Darker red for focus */
    box-shadow: 0 0 5px rgba(231, 76, 60, 0.3); /* Subtle glow */
  }
  .input-box i {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    color: #e74c3c; /* Red icons */
    font-size: 16px;
  }

  /* Button */
  button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 8px;
    background: #e74c3c; /* Red button */
    color: #ffffff;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    font-size: 14px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Shadow for depth */
  }
  button:hover {
    background: #c0392b; /* Darker red on hover */
  }

  /* Links */
  .link-text {
    text-align: center;
    margin-top: 12px;
    font-size: 12px;
    color: #6c757d; /* Muted gray */
  }
  .link-text a {
    color: #e74c3c; /* Red links */
    text-decoration: none;
    font-weight: 600;
  }
  .link-text a:hover {
    text-decoration: underline;
    color: #c0392b; /* Darker red on hover */
  }
</style>
<body>

  <div class="app-title">MOVIE FINDER</div>

  <div class="container" id="authContainer">
    <!-- Login Panel (Text on right, Form on left) -->
    <div class="panel left-panel">
      <h2>Create Your Movie Profile</h2>
      <p>Start exploring movies that excite you...</p>
    </div>
    <div class="form-left form-panel">
      <form action="homepage.php" method="POST">
        <h2 style="text-align:center; margin-bottom:12px; color:#e74c3c;">Log In</h2>
        <div class="input-box">
          <input type="email" name="Username" placeholder="Username" required>
          <i class='bx bx-envelope'></i>
        </div>
        <div class="input-box">
          <input type="password" name="Password" placeholder="Password" required>
          <i class='bx bx-lock-alt'></i>
        </div>
        <button type="submit">Login</button>
        <div class="link-text"><a href="resetpassword.html">Forgot Password?</a></div>
        <div class="link-text">Don't have an account? <a href="#" id="goRegister">Register Now!</a></div>
      </form>
    </div>

    <!-- Register Panel (Text on left, Form on right) -->
    <div class="panel right-panel">
      <h2>Welcome to Movie Finder!</h2>
      <p>Discover amazing movies and find your next favorite film. Log in to start exploring!</p>
    </div>
    <div class="form-right form-panel">
      <form action="homepage.php" method="POST">
        <h2 style="text-align:center; margin-bottom:12px; color:#e74c3c;">Register</h2>
        <div class="input-box">
          <input type="text" name="Name" placeholder="Name" required>
          <i class='bx bx-user'></i>
        </div>
        <div class="input-box">
          <input type="email" name="Username" placeholder="Username" required>
          <i class='bx bx-envelope'></i>
        </div>
        <div class="input-box">
          <input type="password" name="Password" placeholder="Password" required>
          <i class='bx bx-lock-alt'></i>
        </div>
        <button type="submit">Create Account</button>
        <div class="link-text">Already have an account? <a href="#" id="goLogin">Log In</a></div>
      </form>
    </div>
  </div>

  <div class="wave"></div> <!-- If this is used for animation, you might want to style it separately -->

  <script>
    const container = document.getElementById("authContainer");
    const goRegister = document.getElementById("goRegister");
    const goLogin = document.getElementById("goLogin");

    goRegister.addEventListener("click", (e) => {
      e.preventDefault();
      container.classList.add("register-mode");
    });
    goLogin.addEventListener("click", (e) => {
      e.preventDefault();
      container.classList.remove("register-mode");
    });
  </script>

</body>
</html>
