<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Recover Password</title>

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
  $email = $_SESSION["email"];
  $pin = $_SESSION["pin"];

?>
<body>
<h1>Recover Password for <span style="color:blue; text-decoration:underline"><?php echo $email ?></span></h1>
<h2>PIN code for showcase : <?php echo $pin ?></h2>
<form id="form" action="authRecover.php" method="post">
  <div class="container">
    <div style="display:none">
      <label for="email"><b>Email</b></label>
      <input readonly type="text" value="<?php echo $email ?>" placeholder="Enter email" name="email" required>
    </div>

    <label for="pin"><b>PIN</b><span id=pin1 style="color:transparent"> *Please fill in this field</span></label>
    <input type="text" placeholder="Enter PIN" name="pin" id="pin" required>

    <label for="password"><b>Password</b><span id=pass1 style="color:transparent">* Please fill in this field</span></label> 
    <input type="password" placeholder="Enter Password" name="password" id="password" required>
    
    <label for="repassword"><b>Confirm Password</b><span id=pass2 style="color:transparent"> *Please fill in this field</span></label>
    <input type="password" placeholder="Confirm Password" name="repassword" id="repassword" required>

    <button type="button">Submit</button>
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
    if($("#pin").val() == ""){
      $("span").css("color","transparent");
      $("#pin1").css("color","red");
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