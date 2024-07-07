<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
            /* Bordered form */
        form {
        border: 3px solid #f1f1f1;
        }

        /* Full-width inputs */
        input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        }

        /* Set a style for all buttons */
        button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        }

        /* Add a hover effect for buttons */
        button:hover {
        opacity: 0.8;
        }

        /* Center the avatar image inside this container */
        .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
        }

        /* Avatar image */
        img.avatar {
        width: 40%;
        border-radius: 50%;
        }

        /* Add padding to containers */
        .container {
        padding: 16px;
        }

        /* The "Forgot password" text */
        span.psw {
        float: right;
        padding-top: 16px;
        }
    </style>

</head>

<?php 
    session_start();

    if(isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_SESSION['user_type'])) {
      switch($_SESSION['user_type']){
        case "admin":
          header('Location: http://localhost/PassManager/admin.php');
          break;
        default:
          header('Location: http://localhost/PassManager/home.php');
          break;
      }
    }

    if(isset($_SESSION['alert'])) {
        echo '<script>alert("' . $_SESSION['alert'] . '")</script>';
        session_destroy();
    }

?>

<body>
<h1><b>Car Booking System Wai Currus</b></h1>
<form id="form" action="auth.php" method="post">
  <div class="container">
    <label for="username"><b>Username</b><span id=name1 style="color:transparent"> *Please fill in this field</span></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>

    <label for="password"><b>Password</b><span id=pass1 style="color:transparent"> *Please fill in this field</span></label>
    <input type="password" placeholder="Enter Password" name="password" id="password" required>

    <button type="button">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <span class="psw" style=float:left><a href="signup.php">Sign Up</a></span>
    <span class="psw"><a href="forget.php">Forgot password?</a></span>
  </div>
</form>
</body>

<script>
//JQUERY CODE
$(document).ready(function(){
  $("button").click(function(){
    if($("#username").val() == ""){
      $("span").css("color","transparent");
      $("#name1").css("color","red");
    }
    else if($("#password").val() == ""){
      $("#pass1").html(" *Please fill in this field");
      $("span").css("color","transparent");
      $("#pass1").css("color","red");
    }
    else if($("#password").val().length < 8){
      $("#pass1").html(" *Password need to be at least 8 characters");
      $("span").css("color","transparent");
      $("#pass1").css("color","red");
    }
    else{
      $("#form").submit();
    }
  });
});

</script>
</html>