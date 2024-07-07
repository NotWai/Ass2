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
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? OR `email` = ?");
        $stmt->bind_param("ss", $username, $email);

        // set parameters and execute
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password'].$salt)); // md5 encrypt + salt
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                // Set session variables
                $_SESSION["alert"] = "This username or e-mail has been taken!";
                header('Location: http://localhost/PassManager/login.php');
            }
        } else {
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO user (username, email, `password`, user_type) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $password, $usertype);

            // set parameters and execute
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, md5($_POST['password'].$salt)); // md5 encrypt + salt
            $usertype = "customer";
            $stmt->execute();
    
            echo "New record created successfully";
            $_SESSION["alert"] = "You have successfully registered!";
            header('Location: http://localhost/PassManager/login.php');
        }

        $stmt->close();
        $conn->close();
    ?>
<body>
</body>
</html>