<?php
include_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform authentication by querying the database with prepared statements
    $query = "SELECT company_password FROM company WHERE company_username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPasswordFromDB = $row["company_password"];

        if (password_verify($password, $hashedPasswordFromDB)) {
            // Successful login
            session_start();
            $_SESSION["company_username"] = $username;

            // Display a success alert
            echo '<script>alert("Login successful!");</script>';

            // Redirect to the index page
            header("Location: index.php");
            exit();
        } else {
            // Password does not match
            echo '<script>alert("Invalid username or password");</script>';
        }
    } else {
        // User not found
        echo '<script>alert("Invalid username or password");</script>';
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form | CodingLab</title> 
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
      }
      body {
        background: ;
        overflow: hidden;
      }
      ::selection {
        background: rgba(0, 0, 255, 1);
      }
      .container {
        max-width: 440px;
        padding: 0 20px;
        margin: 170px auto;
      }
      .wrapper {
        width: 100%;
        background: #fff;
        border-radius: 5px;
        box-shadow: 0px 4px 10px 1px rgba(0, 0, 0, 0.1);
      }
      .wrapper .title {
        height: 90px;
        background: #009cff;
        border-radius: 5px 5px 0 0;
        color: #fff;
        font-size: 30px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .wrapper form {
        padding: 30px 25px 25px 25px;
      }
      .wrapper form .row {
        height: 45px;
        margin-bottom: 15px;
        position: relative;
      }
      .wrapper form .row input {
        height: 100%;
        width: 100%;
        outline: none;
        padding-left: 60px;
        border-radius: 5px;
        border: 1px solid lightgrey;
        font-size: 16px;
        transition: all 0.3s ease;
      }
      form .row input:focus {
        border-color: #009cff;
        box-shadow: inset 0px 0px 2px 2px rgba(26, 188, 156, 0.25);
      }
      form .row input::placeholder {
        color: #999;
      }
      .wrapper form .row i {
        position: absolute;
        width: 47px;
        height: 100%;
        color: #fff;
        font-size: 18px;
        background: #009cff;
        border: 1px solid #009cff;
        border-radius: 5px 0 0 5px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .wrapper form .pass {
        margin: -8px 0 20px 0;
      }
      .wrapper form .pass a {
        color: #000000;
        font-size: 17px;
        text-decoration: none;
      }
      .wrapper form .pass a:hover {
        text-decoration: underline;
      }
      .wrapper form .button input {
        color: #fff;
        font-size: 20px;
        font-weight: 500;
        padding-left: 0px;
        background: #009cff;
        border: 1px solid #009cff;
        cursor: pointer;
      }
      form .button input:hover {
        background: #009cff;
      }
      .wrapper form .signup-link {
        text-align: center;
        margin-top: 20px;
        font-size: 17px;
      }
      .wrapper form .signup-link a {
        color: #009cff;
        text-decoration: none;
      }
      form .signup-link a:hover {
        text-decoration: underline;
      }
      
  /* Style for the "Forgot Password?" link */
  .forgot-password-link a {
    color: #009cff; /* Change this to your desired color */
    text-decoration: none; /* Remove underline */
  }

  .forgot-password-link a:hover {
    text-decoration: underline; /* Add underline on hover */
  }
    </style>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Login </span></div>
        <form method="POST" action="user_login.php">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="forgot-password-link">
            <a href="forgot-password.php">Forget Password?</a>
            &nbsp;
            &nbsp;
          <div class="row button">
            <input type="submit" value="Login">
          </div>
          <div class="signup-link">Not Have an account? <a href="user_register.php">Register now</a></div>
        </form>
        
      </div>
    </div>
  </body>
</html>
