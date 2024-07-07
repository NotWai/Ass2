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
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $model = mysqli_real_escape_string($conn, $_POST['model']);
        $year = mysqli_real_escape_string($conn, $_POST['year']);
        $stock = mysqli_real_escape_string($conn, $_POST['stock']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        switch($type) {
            case "Sedan":
                $price = mysqli_real_escape_string($conn, 310);
                break;
            case "SUV":
                $price = mysqli_real_escape_string($conn, 320);
                break;
            case "Hatchback":
                $price = mysqli_real_escape_string($conn, 200);
                break;
            case "MPV":
                $price = mysqli_real_escape_string($conn, 300);
                break;
            default:
                $price = mysqli_real_escape_string($conn, 0);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        // output data of each row
            $_SESSION["alert"] = "This car has already been added!";
            header('Location: http://localhost/PassManager/admin.php');
        }else{
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO car (brand, model, `year`, stock, `type`, price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $brand, $model, $year, $stock, $type, $price);

            // set parameters and execute

            $stmt->execute();
        
            $_SESSION["alert"] = "You have added a new car!";
            header('Location: http://localhost/PassManager/admin.php');
        }

        $stmt->close();
        $conn->close();
    ?>
<body>
</body>
</html>