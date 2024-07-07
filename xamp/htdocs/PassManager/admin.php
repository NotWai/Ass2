<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<?php
    include('config.php');


    if(!isset($_SESSION['user_id']) && !isset($_SESSION['username']) && !isset($_SESSION['email']) && !isset($_SESSION['user_type'])) {
        header('Location: http://localhost/PassManager/login.php');
    }else{
        switch($_SESSION['user_type']){
            case "customer":
              header('Location: http://localhost/PassManager/home.php');
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
        unset($_SESSION['alert']);
    }


?>
<body>
    <div class="p-4">
        <header>
            <h1>Welcome, <span style="color:blue"><?php echo $_SESSION['username']; ?></span></h1>
            <button style="float:right" onclick="logout()" type="button" class="btn btn-success">Logout</button>
            <a hidden id="logoutButton" style="text-decoration:none;color:white" href="logout.php">Logout</a>
        </header>
        <!-- <main>
            <img src="images/gmbr.jpg" height="800" width="500" title="Zuhair Isyraq Bin Zairil B22EC3015">
        </main> -->

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add New Car
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" action="addNewCar.php" method="post" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="brand"><b>Car Brand</b></label>
                            <input type="text" class="form-control" placeholder="Enter car brand" name="brand" id="brand" required>
                            <div class="invalid-feedback">
                                Please enter a username.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="model"><b>Car Model</b></label>
                            <input type="text" class="form-control" placeholder="Enter car model" name="model" id="model" required>
                            <div class="invalid-feedback">
                                Please enter a car model.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="year"><b>Year</b></label>
                            <input type="number" class="form-control" placeholder="Enter year" name="year" id="year" required>
                            <div class="invalid-feedback">
                                Please enter a year.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stock"><b>Stock</b></label>
                            <input type="number" class="form-control" placeholder="Enter stock" name="stock" id="stock" required>
                            <div class="invalid-feedback">
                                Please enter car stock.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type"><b>Car Type</b></label> &emsp;
                            <select name="type" id="type" class="form-control" required>
                                <option  selected disabled value="">Select Car Type</option>
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="MPV">MPV</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select car type.
                            </div>
                        </div>

                        <input hidden name="username" value="<?php echo $_SESSION['username']; ?>" required>
                        <input hidden name="email" value="<?php echo $_SESSION['email']; ?>" required>
                        <input hidden type="submit" id="add">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="document.getElementById('add').click();" class="btn btn-primary">Add</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" action="editCar.php" method="post" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="brandEdit"><b>Car Brand</b></label>
                            <input type="text" class="form-control" placeholder="Enter car brand" name="brandEdit" id="brandEdit" required>
                            <div class="invalid-feedback">
                                Please enter a username.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modelEdit"><b>Car Model</b></label>
                            <input type="text" class="form-control" placeholder="Enter car model" name="modelEdit" id="modelEdit" required>
                            <div class="invalid-feedback">
                                Please enter a car model.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="yearEdit"><b>Year</b></label>
                            <input type="number" class="form-control" placeholder="Enter year" name="yearEdit" id="yearEdit" required>
                            <div class="invalid-feedback">
                                Please enter a year.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stockEdit"><b>Stock</b></label>
                            <input type="number" class="form-control" placeholder="Enter stock" name="stockEdit" id="stockEdit" required>
                            <div class="invalid-feedback">
                                Please enter car stock.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="typeEdit"><b>Car Type</b></label> &emsp;
                            <select name="typeEdit" id="typeEdit" class="form-control" required>
                                <option  selected disabled value="">Select Car Type</option>
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="MPV">MPV</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select car type.
                            </div>
                        </div>

                        <input hidden name="username" value="<?php echo $_SESSION['username']; ?>" required>
                        <input hidden name="email" value="<?php echo $_SESSION['email']; ?>" required>
                        <input hidden name="carID" id="carIDEdit" required>
                        <input hidden type="submit" id="edit">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="editForm()" class="btn btn-primary">Save</button>
                </div>
                </div>
            </div>
        </div>

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
                                        <th scope='row'>".$row["car_id"]."</th>
                                        <td>".$row["brand"]."</td>
                                        <td>".$row["model"]."</td>
                                        <td>".$row["type"]."</td>
                                        <td>".$row["price"]."</td>
                                        <td>".$row["year"]."</td>
                                        <td>".$row["stock"]."</td>
                                        <td>
                                            <button hidden id='editModalButton' data-bs-toggle='modal' data-bs-target='#editModal'></button>
                                            <button type='button' class='btn btn-primary' onclick='edit(".$row["car_id"].", `".$row["brand"]."`, `".$row["model"]."`, `".$row["type"]."`, " .$row["price"].", " .$row["year"].", " .$row["stock"].")'>Edit</button>
                                            <button type='button' onclick='deleteProcess(".$row["car_id"].")' class='btn btn-danger'>Delete</button>

                                            <form action='deleteCar.php' method='post' id='delete".$row["car_id"]."'>
                                                <input hidden name='car_id' value=".$row["car_id"].">
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

</body>
</html>

<script>

    function edit(id, brand, model, type, price, year, stock){
        console.log(id, brand, model, type, price, year, stock)
        document.getElementById("carIDEdit").value = id;
        document.getElementById("brandEdit").value = brand;
        document.getElementById("modelEdit").value = model;
        document.getElementById("typeEdit").value = type;
        document.getElementById("yearEdit").value = year;
        document.getElementById("stockEdit").value = stock;
        document.getElementById("editModalButton").click();
    }

    function editForm(){
        Swal.fire({
            title: "Do you want to update this car?",
            icon: "info",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: `No`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                document.getElementById('edit').click();
            } else if (result.isDenied) {
                // Swal.fire("Changes are not saved", "", "info");
            }
        });
    }

    function deleteProcess(car_id){
        Swal.fire({
            title: "Do you want to delete this car?",
            icon: "info",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: `No`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                document.getElementById("delete"+car_id).submit();
            } else if (result.isDenied) {
                // Swal.fire("Changes are not saved", "", "info");
            }
        });
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