<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Page</title>

</head>
    <?php
        include('config.php');

        //to solve sql injection attacks, use prepared statements

        // prepare and bind
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND `password` = ?"); // prepare empty SQL statement
        $stmt->bind_param("ss", $username, $password); //prepare empty parameters

        // set parameters and execute
        $username = mysqli_real_escape_string($conn, $_POST['username']); //give value to parameters
        $password = mysqli_real_escape_string($conn, md5($_POST['password'].$salt)); // md5 encrypt + salt
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) {
                    // Set session variables
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["user_id"] = $row["user_id"];
                    // $_SESSION["password"] = "$password";
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["user_type"] = $row["user_type"];
                    $_SESSION["session_id"] = rand(100000,999999); 

                    // prepare and bind
                    $stmt = $conn->prepare("UPDATE user SET session_id = ? WHERE user_id = ?");
                    $stmt->bind_param("ss",  $_SESSION["session_id"], $row["user_id"]);
            
                    // set parameters and execute
                    $stmt->execute();

                    if($row["user_type"] === "admin"){
                        header('Location: http://localhost/PassManager/admin.php');
                    }else{
                        header('Location: http://localhost/PassManager/home.php');
                    }
                }
        } else {
            $_SESSION["alert"] = "Invalid e-mail or password!";
            header('Location: http://localhost/PassManager/login.php');
        }

        $stmt->close();
        $conn->close();
    ?>
<body>
</body>
</html>