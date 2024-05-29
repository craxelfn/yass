<?php
session_start();
require 'config.php';

// Get the user's service_id
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    // Redirect to login page if user is not logged in
    header("Location: seconnect.php");
    exit();
}

// Fetch service_id of the logged-in user
$service_query = "SELECT service_id FROM Utilisateurs WHERE utilisateur_id = '$user_id'";
$service_result = mysqli_query($connection, $service_query);
$service_data = mysqli_fetch_assoc($service_result);
$service_id = $service_data['service_id'];

// Fetch number of vehicles for the service
$vehicle_query = "SELECT COUNT(*) AS num_vehicles FROM Vehicules WHERE service_id = '$service_id'";
$vehicle_result = mysqli_query($connection, $vehicle_query);
$num_vehicles_data = mysqli_fetch_assoc($vehicle_result);
$num_vehicles = $num_vehicles_data['num_vehicles'];

// Fetch number of available vehicles for the service
$available_vehicle_query = "SELECT COUNT(*) AS num_available FROM Vehicules WHERE service_id = '$service_id' AND est_occupe = FALSE";
$available_vehicle_result = mysqli_query($connection, $available_vehicle_query);
$num_available_data = mysqli_fetch_assoc($available_vehicle_result);
$num_available = $num_available_data['num_available'];

// Fetch number of missions created by the service
$mission_query = "SELECT COUNT(*) AS num_missions FROM Missions WHERE service_id = '$service_id'";
$mission_result = mysqli_query($connection, $mission_query);
$num_missions_data = mysqli_fetch_assoc($mission_result);
$num_missions = $num_missions_data['num_missions'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/project.css">
    <link rel="stylesheet" href="styles/boss-dash.css">
    <title>home page</title>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="main">
            <?php include 'nav.php'; ?>
            <div class="container   mt-5  mb-5">
                <div class="row ">
                    <div class="col-lg-4">
                        <div class="card text-uppercase numproj mb-3">
                            <div class="card-body">
                                <h4>car number :</h4>
                                <h1 class="text-center mt-3 text-black-50"><?php echo $num_vehicles; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card text-uppercase profit mb-3">
                            <div class="card-body">
                                <h4>car dispo</h4>
                                <h1 class="text-center mt-3 text-black-50"><?php echo $num_available; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-uppercase proj-num mb-4">
                        <div class="card numproj">
                            <div class="card-body">
                                <h4>mission num</h4>
                                <h1 class="text-center mt-3 text-black-50"><?php echo $num_missions; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Missions Details Table -->
            <div class="container mb-5 mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header  d-flex justify-content-between ">
                                <h4 class="text-black">missions details</h4>
                                <div class=" float-end ">
                                    <button class="btn  btn-primary ">add-mission</button>
                                </div>
                            </div>
                            <div class="card-body">

                                <table class="table table-bordered  text-center    custom-table">
                                    <thead>
                                        <tr>
                                            <th>conducteur</th>
                                            <th>voiture</th>
                                            <th>seat-availble</th>
                                            <th>date</th>
                                            <th>time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Populate with mission data from database -->
                                        <!-- Example row -->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class=" d-flex gap-2">
                                                <div>
                                                    <a                                                        href="" class=" mb-2 btn btn-info btn-sm">View</a>
                                                </div>
                                                <div class="">
                                                    <form action="" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_mission" value="mission_id" class="btn btn-danger btn-sm mb-2">Delete</button> 
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cars Details Table -->
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card crudtab">
                            <div class="card-header">
                                <h4 class="text-black">cars details
                                    <select class="form-select float-end" aria-label="Default select example">
                                        <option selected>ALL</option>
                                        <option value="1">hilux</option>
                                        <option value="2">dacia</option>
                                        <option value="3">logan</option>
                                        <option value="4">hilux</option>
                                    </select>
                                    <button class="btn  btn-primary float-end ">add-car</button>
                                </h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-bordered  text-center    custom-table">
                                    <thead>
                                        <tr>
                                            <th>image</th>
                                            <th>marque</th>
                                            <th>matricule</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Populate with car data from database -->
                                        <!-- Example row -->
                                        <tr>
                                            <td><img src="image/hiluximg.jpg" class="img-fluid" alt=""></td>
                                            <td></td>
                                            <td></td>
                                            <td class=" d-flex gap-2">
                                                <div>
                                                    <form action="" method="POST" class=" d-inline">
                                                        <button type="submit" name="delete_car" value="car_id" class="btn btn-danger  mb-2">Delete</button> 
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>

