<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Page</title>

</head>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "PassManager";

        // Create connection
        $conn = new mysqli($servername, $username, $password , $db);

        // Check connection
        // if ($conn->connect_error) {
        // die("Connection failed: " . $conn->connect_error);
        // }
        // echo "Connected successfully";

        $sql = "SELECT * FROM user";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["user_id"]. " - Username: " . $row["username"]. " " . $row["email"]. "<br>";
        }
        } else {
        echo "0 results";
        }

        $sql = "INSERT INTO user (username, email, `password`)
        VALUES ('Shah', 'shah@gmail.com', md5('Abc123'))";

        // if ($conn->query($sql) === TRUE) {
        // echo "New record created successfully";
        // } else {
        // echo "Error: " . $sql . "<br>" . $conn->error;
        // }

        $sql = "UPDATE user SET `password` = md5('Doe') WHERE user_id=4";

        if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        } else {
        echo "Error updating record: " . $conn->error;
        }

        $conn->close();
    ?>
<body>
</body>
</html> -->