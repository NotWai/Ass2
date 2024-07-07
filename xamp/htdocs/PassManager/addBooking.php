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
        $stmt = $conn->prepare("SELECT * FROM car WHERE model= ? ");
        $stmt->bind_param("s", $model);

        // set parameters and execute
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $carID = mysqli_real_escape_string($conn, $_POST['carID']);
        $sdate = mysqli_real_escape_string($conn, $_POST['sdate']);
        $edate = mysqli_real_escape_string($conn, $_POST['edate']);
        $status = "booked";

        $starting = strtotime($sdate);
        $end = strtotime($edate);
        $datediff = $end - $starting;
        $datediff = round($datediff / (60 * 60 * 24));
        if($datediff < 1){
            $datediff = 1;
        }
        $total = $price* $datediff;
        $today = date("Y/m/d");

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO booking (user_id, car_id, booking_date, total_fee, `status`, `start_date`, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $user_id, $carID, $today, $total, $status, $sdate, $edate);

        // set parameters and execute

        $stmt->execute();
        
        $_SESSION["alert"] = "You have booked a car!";
        header('Location: http://localhost/PassManager/home.php');

        $stmt->close();
        $conn->close();
    ?>
<body>
</body>
</html>