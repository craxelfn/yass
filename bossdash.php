<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id']) ) {
    header("Location: seconnect.php");
    exit();
}
// Get the user's service_id
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    // Redirect to login page if user is not logged in
    header("Location: seconnect.php");
    exit();
}
$user_id = $_SESSION['user_id'];

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
$available_vehicle_query = "SELECT COUNT(*) AS num_available FROM Utilisateurs WHERE service_id = '$service_id' ";
$available_vehicle_result = mysqli_query($connection, $available_vehicle_query);
$num_available_data = mysqli_fetch_assoc($available_vehicle_result);
$num_available = $num_available_data['num_available'];


// Fetch number of missions created by the service
$mission_query = "SELECT COUNT(*) AS num_missions FROM Missions WHERE service_id = '$service_id' AND est_supprimer=0 ";
$mission_result = mysqli_query($connection, $mission_query);
$num_missions_data = mysqli_fetch_assoc($mission_result);
$num_missions = $num_missions_data['num_missions'];



// Prepare and execute SQL query to fetch cars for the user's service
$select_cars_query = "SELECT * FROM Vehicules WHERE service_id = '$service_id' AND est_supprimer = 0";
$stmt_select_cars = $connection->query($select_cars_query);


// Fetch service_id of the logged-in user
$service_query = "SELECT service_id FROM Utilisateurs WHERE utilisateur_id = '$user_id'";
$service_result = mysqli_query($connection, $service_query);
$service_data = mysqli_fetch_assoc($service_result);
$service_id = $service_data['service_id'];

// Prepare and execute SQL query to fetch missions for the user's service
$select_missions_query = "SELECT Missions.*, Utilisateurs.nom_utilisateur AS conducteur, Vehicules.vehicule_id, Vehicules.marque AS voiture_marque, Vehicules.nombre_places AS voiture_places
                          FROM Missions 
                          INNER JOIN Utilisateurs ON Missions.conducteur_id = Utilisateurs.utilisateur_id 
                          INNER JOIN Vehicules ON Missions.vehicule_id = Vehicules.vehicule_id 
                          WHERE Missions.service_id = '$service_id' AND Missions.est_supprimer = 0";
$stmt_select_missions = $connection->query($select_missions_query);

// Check if the delete button is clicked
if (isset($_POST['delete_mission'])) {
    // Get the mission ID from the form submission
    $mission_id = $_POST['delete_mission'];

    // Prepare and execute update query to mark the mission as deleted
    $update_old_missions_query = "UPDATE Missions SET est_supprimer = 1 WHERE mission_id = ?";
    $stmt_update_old_missions = $connection->prepare($update_old_missions_query);
    $stmt_update_old_missions->bind_param("i", $mission_id);
    $stmt_update_old_missions->execute();

    // Redirect back to the same page to refresh mission details
    header("Location: your_page.php");
    exit();
}


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
                                <h4>worker number : </h4>
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
                                    <a class="btn  btn-primary" href="addmission.php">add-mission</a>
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
                                        <?php
                                        // Output data of each row
                                        while ($row = $stmt_select_missions->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["conducteur"] . "</td>";
                                            echo "<td>" . $row["vehicule_id"] . " - " . $row["voiture_marque"] . "</td>";
                                            echo "<td>" . ($row["voiture_places"] - $row["nombre_places_reserves"]) . "</td>";
                                            echo "<td>" . date("Y-m-d", strtotime($row["date_heure"])) . "</td>";
                                            echo "<td>" . date("H:i", strtotime($row["date_heure"])) . "</td>";
                                            echo "<td class='d-flex gap-2'>
                                                        <div class=''>
                                                            <form action='' method='POST' class='d-inline'>
                                                                <button type='submit' name='delete_mission' value='" . $row["mission_id"] . "' class='btn btn-danger btn-sm mb-2'>Delete</button> 
                                                            </form>
                                                        </div>
                                                    </td>";
                                            echo "</tr>";
                                        }
                                        ?>
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
                                    <a class="btn btn-primary float-end" href="addcar.php">add-car</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center custom-table">
                                    <thead>
                                        <tr>
                                            <th>image</th>
                                            <th>marque</th>
                                            <th>matricule</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Output data of each row
                                        while ($row = $stmt_select_cars->fetch_assoc()) {
                                            echo "<tr>";
                                            // Dynamically generate image path based on car marque
                                            $marque_without_spaces = str_replace(' ', '', $row['marque']);
                                            $image_path = "image/" . $marque_without_spaces . ".png";
                                            echo "<td><img src='" . $image_path . "' class='img-fluid' alt=''></td>";
                                            echo "<td>" . $row["marque"] . "</td>";
                                            echo "<td>" . $row["vehicule_id"] . "</td>";
                                            echo "<td class='d-flex gap-2'>
                                                    <div>
                                                        <form action='' method='POST' class='d-inline'>
                                                            <button type='submit' name='delete_car' value='" . $row["vehicule_id"] . "' class='btn btn-danger  mb-2'>Delete</button> 
                                                        </form>
                                                    </div>
                                                </td>";
                                            echo "</tr>";
                                        }
                                        ?>
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

