<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignupPage</title>

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

        /* Add padding to containers */
        .container {
        padding: 16px;
        }

        /* The "Back to login" text */
        span.psw {
        float: right;
        padding-top: 16px;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<?php 
    session_start();
    if(isset($_SESSION['alert'])) {
        echo '<script>alert("' . $_SESSION['alert'] . '")</script>';
        session_destroy();
    }
?>

<body>
<h1>Signup Form</h1>
<form id="form" action="authSignup.php" method="post">
  <div class="container">
    <label for="username"><b>Username</b><span id=name1 style="color:transparent"> *Please fill in this field</span></label>
    <input type="text" placeholder="Enter Username" name="username" id=username required>

    <label for="email"><b>Email</b><span id=email1 style="color:transparent"> *Please fill in this field</span></label>
    <input type="text" placeholder="Enter Email" name="email" id=email required>

    <label for="password"><b>Password</b><span id=pass1 style="color:transparent"> *Please fill in this field</span></label>
    <input type="password" placeholder="Enter Password" name="password" id=password required>

    <label for="repassword"><b>Confirm Password</b><span id=pass2 style="color:transparent"> *Please fill in this field</span></label>
    <input type="password" placeholder="Confirm Password" name="repassword" id=repassword required>

    <button type="button">Signup</button>

  </div>

  <div class="container" style="background-color:#f1f1f1">
    <span class="psw"><a href="login.php">Back to login</a></span>
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
    else if($("#email").val() == ""){
      $("span").css("color","transparent");
      $("#email1").css("color","red");
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
    else if($("#repassword").val() == ""){
      $("span").css("color","transparent");
      $("#pass2").css("color","red");
    }
    else if($("#password").val() != $("#repassword").val()) {
      $("span").css("color","transparent");
      $("#pass1").css("color","red");
      $("#pass1").html(" *Password need to be same");
    }
    else{
      $("#form").submit();
    }
  });
});

</script>
</html>