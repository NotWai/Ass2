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

        // set parameters and execute
        $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        echo $booking_id, $status;

        // prepare and bind
        $stmt = $conn->prepare("UPDATE booking SET `status` = ? WHERE booking_id = ?");
        $stmt->bind_param("ss",  $status, $booking_id);

        // set parameters and execute
        $stmt->execute();

        $_SESSION["alert"] = "You have $status a booking!";
        header('Location: http://localhost/PassManager/home.php');

        $stmt->close();
        $conn->close();
    ?>
<body>
</body>
</html>