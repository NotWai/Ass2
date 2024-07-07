<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        td, th {
            text-align: center;
        }
    </style>
</head>
<?php
    include('config.php');

    echo '
    <script>
        function activeTab(){
            
        }
    </script>';

    if(!isset($_SESSION['user_id']) && !isset($_SESSION['username']) && !isset($_SESSION['email']) && !isset($_SESSION['user_type'])) {
        header('Location: http://localhost/PassManager/login.php');
    }else{
        switch($_SESSION['user_type']){
            case "admin":
              header('Location: http://localhost/PassManager/admin.php');
              break;
            default:
              break;
          }
    }

    if(isset($_SESSION['alert'])) {
        echo '
        <script type="text/javascript">

        $(document).ready(function(){
            swal.fire({text:"'.$_SESSION['alert']. '", icon:"info"})
        });

        </script>';

        if($_SESSION['alert'] == "You have booked a car!"){
            echo '
            <script>
                function activeTab(){
                    document.getElementById("profile-tab").click()
                }
            </script>';
        }
        unset($_SESSION['alert']);
    }


?>
<body onload="activeTab()">
    <header>
        <h1>Welcome to My Homepage, <span style="color:blue"><?php echo $_SESSION['username']; ?></span></h1>
        <button style="float:right" onclick="logout()" type="button" class="btn btn-success">Logout</button>
        <a hidden id="logoutButton" style="text-decoration:none;color:white" href="logout.php">Logout</a>
    </header>
    <div class="modal fade" id="bookModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Book Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" action="addBooking.php" method="post" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="sdate"><b>Starting Date</b></label>
                            <input type="date" class="form-control" placeholder="Enter starting date" name="sdate" id="sdate" required>
                            <div class="invalid-feedback">
                                Please enter a date.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edate"><b>End Date</b></label>
                            <input type="date" class="form-control" placeholder="Enter end date" name="edate" id="edate" required>
                            <div class="invalid-feedback">
                                Please enter a date.
                            </div>
                        </div>

                        <input hidden name="username" value="<?php echo $_SESSION['username']; ?>" required>
                        <input hidden name="email" value="<?php echo $_SESSION['email']; ?>" required>
                        <input hidden name="user_id" value="<?php echo $_SESSION['user_id']; ?>" required>
                        <input hidden name="carID" id="carIDBook" required>
                        <input hidden name="price" id="price" required>
                        <input hidden type="submit" id="book">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="book()" class="btn btn-primary">Book</button>
                </div>
                </div>
            </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Car List</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Booking List</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" onclick="clickMe()"  type="button" role="tab">Brand List</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Model</th>
                            <th scope="col">Type</th>
                            <th scope="col">Price (RM)</th>
                            <th scope="col">Year</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                                    // prepare and bind
                                    $stmt = $conn->prepare("SELECT * FROM car"); // prepare empty SQL statement

                                    // set parameters and execute
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                echo "
                                                <th scope='row'>CAR".$row["car_id"]."</th>
                                                <td>".$row["brand"]."</td>
                                                <td>".$row["model"]."</td>
                                                <td>".$row["type"]."</td>
                                                <td>".$row["price"]."</td>
                                                <td>".$row["year"]."</td>
                                                <td>".$row["stock"]."</td>
                                                <td>
                                                    <button hidden id='bookModalButton' data-bs-toggle='modal' data-bs-target='#bookModal'></button>
                                                    <button type='button' class='btn btn-primary' onclick='edit(".$row["car_id"].", `".$row["brand"]."`, `".$row["model"]."`, `".$row["type"]."`, " .$row["price"].", " .$row["year"].", " .$row["stock"].")'>Book</button>
                                                </td>
                                                </tr>
                                                ";
                                            }
                                    }else{
                                        echo "
                                        <th>No data</th>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        </tr>
                                        ";
                                    }
                            
                            ?>
                    </tbody>
            </table>
        </div>
        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Model</th>
                            <th scope="col">Type</th>
                            <th scope="col">Year</th>
                            <th scope="col">Total Fee (RM)</th>
                            <th scope="col">Status</th>
                            <th scope="col">Booking Date</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Return Date</th>
                            <th scope="col">Duration (Day)</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                                    // prepare and bind
                                    $stmt = $conn->prepare("SELECT * FROM booking INNER JOIN car ON booking.car_id = car.car_id WHERE booking.user_id = $_SESSION[user_id] ORDER BY booking_id DESC"); // prepare empty SQL statement

                                    // set parameters and execute
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                if($row["status"] != "booked"){
                                                    $hidden = "hidden";
                                                }else{
                                                    $hidden = "";
                                                }
                                                switch($row["status"]){
                                                    case "booked":
                                                        $badge = "primary";
                                                        break;
                                                    case "returned":
                                                        $badge = "success";
                                                        break;
                                                    default:
                                                        $badge = "danger";
                                                        break;
                                                }
                                                echo "
                                                <th scope='row'>BOOK".$row["booking_id"]."</th>
                                                <td>".$row["brand"]."</td>
                                                <td>".$row["model"]."</td>
                                                <td>".$row["type"]."</td>
                                                <td>".$row["year"]."</td>
                                                <td>".$row["total_fee"]."</td>
                                                <td><span class='badge rounded-pill bg-$badge'>".$row["status"]."</span></td>
                                                <td>".date("d F Y", strtotime($row["booking_date"]) )."</td>
                                                <td>".date("d F Y", strtotime($row["start_date"]) )."</td>
                                                <td>".date("d F Y", strtotime($row["end_date"]) )."</td>
                                                <td>".round( (strtotime($row["end_date"]) - strtotime($row["start_date"]) ) / (60 * 60 * 24))."</td>
                                                <td>
                                                    <button type='button' ".$hidden." onclick='update(".$row["booking_id"].", `returned`)' class='btn btn-success'>Return</button>
                                                    <button type='button' ".$hidden." onclick='update(".$row["booking_id"].", `canceled`)' class='btn btn-danger'>Cancel</button>

                                                    <form action='updateBooking.php' method='post' id='update".$row["booking_id"]."'>
                                                        <input hidden name='booking_id' value=".$row["booking_id"].">
                                                        <input hidden name='status' id='status".$row["booking_id"]."'>
                                                    </form>
                                                </td>
                                                </tr>
                                                ";
                                            }
                                    }else{
                                        echo "
                                        <th>No data</th>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        </tr>
                                        ";
                                    }
                            
                            ?>
                    </tbody>
            </table>
        </div>
    </div>



    <!-- <main>
        <img src="images/gmbr.jpg" height="800" width="500" title="Zuhair Isyraq Bin Zairil B22EC3015">
    </main> -->
<!-- <button ><a style="text-decoration:none" href="logout.php">Logout</a></button> -->
</body>
</html>

<script>
    function clickMe(){
        window.location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ&pp";
    }

    function edit(id, brand, model, type, price, year, stock){
        console.log(id, brand, model, type, price, year, stock)
        document.getElementById("bookModalLabel").innerHTML = brand + " " + model;
        document.getElementById("carIDBook").value = id;
        document.getElementById("price").value = price;
        document.getElementById("bookModalButton").click();
    }

    function update(id, status){
        console.log(id, status)
        document.getElementById("status"+id).value = status;
        document.getElementById("update"+id).submit();
    }

    function book(){
        let sdate = Date.parse(document.getElementById("sdate").value)
        let edate = Date.parse(document.getElementById("edate").value)
        let day = ( (edate - sdate)/ (60 * 60 * 24) ) / 1000
        if(day < 1){
            Swal.fire({
                title: "You must book the car for at least 1 day",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }else{
            Swal.fire({
                title: "Do you want to book this car?",
                icon: "info",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: `No`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    document.getElementById('book').click();
                } else if (result.isDenied) {
                    // Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

    }

    function logout(text){
        Swal.fire({
            title: "Do you want to logout?",
            icon: "info",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: `No`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                document.getElementById("logoutButton").click();
            } else if (result.isDenied) {
                // Swal.fire("Changes are not saved", "", "info");
            }
        });
    }

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
            });
        }, false);
    })();
</script>