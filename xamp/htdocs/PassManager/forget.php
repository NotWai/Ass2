<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
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
    if(isset($_SESSION['alert'])) {
        echo '<script>alert("' . $_SESSION['alert'] . '")</script>';
        session_destroy();
    }
?>

<body>
<h1>Forgot Password</h1>
<p>Enter your email and we will send you a pin code to your email</p>
<form id="form" action="authForget.php" method="post">
  <div class="container">
    <label for="email"><b>Email</b><span id=email1 style="color:transparent"> *Please fill in this field</span></label>
    <input type="text" placeholder="Enter email" name="email" id="email" required>

    <button type="button">Submit</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <span class="psw" ><a href="login.php">Back to login</a></span>
  </div>
</form>
</body>
<script>
//JQUERY CODE
$(document).ready(function(){
  $("button").click(function(){
    if($("#email").val() == ""){
      $("span").css("color","transparent");
      $("#email1").css("color","red");
    }
    else{
      $("#form").submit();
    }
  });
});

</script>
</html>