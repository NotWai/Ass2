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

        // prepare and bind
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND pin = ?");
        $stmt->bind_param("ss", $email, $pin);

        // set parameters and execute
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pin = mysqli_real_escape_string($conn, $_POST['pin']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                // prepare and bind
                $stmt = $conn->prepare("UPDATE user SET `password`= ? WHERE user_id = ?");
                $stmt->bind_param("ss", $password, $user_id);

                // set parameters and execute
                $user_id = mysqli_real_escape_string($conn, $row["user_id"]);
                $password = mysqli_real_escape_string($conn, md5($_POST['password'].$salt)); // md5 encrypt + salt
                $stmt->execute();
        
                echo "Record updated successfully";
                $_SESSION["email"] = "$email";
                $_SESSION["alert"] = "You have successfully reset your password!";
                header('Location: http://localhost/PassManager/login.php');
            }
        } else {
            $_SESSION["alert"] = "Invalid PIN.";
            header("Location: http://localhost/PassManager/forget.php");
        }
    ?>
<body>
</body>
</html>