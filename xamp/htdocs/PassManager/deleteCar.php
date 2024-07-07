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
        $stmt = $conn->prepare("DELETE FROM car WHERE car_id= ? ");
        $stmt->bind_param("s", $car_id);

        // set parameters and execute
        $car_id = mysqli_real_escape_string($conn, $_POST['car_id']);

        $stmt->execute();
        
        $_SESSION["alert"] = "You have deleted a car!";
        header('Location: http://localhost/PassManager/admin.php');

        $stmt->close();
        $conn->close();
    ?>
<body>
</body>
</html>