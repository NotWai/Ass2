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
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);

        // set parameters and execute
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                $rand = rand(100000,999999); //generate six digit of random number

                // prepare and bind
                $stmt = $conn->prepare("UPDATE user SET pin= ? WHERE user_id = ?");
                $stmt->bind_param("ss", $pin, $user_id);

                // set parameters and execute
                $user_id = mysqli_real_escape_string($conn, $row["user_id"]);
                $pin = mysqli_real_escape_string($conn, $rand); // md5 encrypt + salt
                $stmt->execute();

                echo "Record updated successfully";
                $_SESSION["email"] = "$email";
                $_SESSION["pin"] = $rand ;
                $_SESSION["alert"] = "A PIN code has been sent to your e-mail";
                header("Location: http://localhost/PassManager/recoverPass.php");
            }
        } else {
            $_SESSION["alert"] = "Invalid e-mail";
            header("Location: http://localhost/PassManager/forget.php");
        }
    ?>
<body>
</body>
</html>