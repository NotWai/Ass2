
    <?php
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "PassManager";
        $salt = "ayam"; // added to every password instances before encryption

        // Create connection
        $conn = new mysqli($servername, $username, $password , $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // echo "Connected successfully";

    ?>
