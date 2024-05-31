<?php
session_start();
// Include database connection file
include 'config.php';

// Check if session variables are set
if (!isset($_SESSION['user_id']) ) {
    header("Location: seconnect.php");
    exit();
}
if (!isset($_SESSION['user_service'])) {
    die("vous avez pas in service .");
}

$user_id = $_SESSION['user_id'];
$user_service = $_SESSION['user_service'];

// Retrieve workers in the same service
$workers_query = "
    SELECT utilisateur_id, nom_utilisateur 
    FROM Utilisateurs 
    WHERE service_id = '$user_service' AND utilisateur_id != '$user_id'
";
$workers_result = mysqli_query($connection, $workers_query);

if (!$workers_result) {
    die("Error in workers query: " . mysqli_error($connection));
}

// Retrieve available vehicles
$vehicles_query = "
    SELECT MIN(vehicule_id) AS vehicule_id, marque 
    FROM Vehicules 
    WHERE est_occupe = FALSE 
    AND service_id = '$user_service'
    GROUP BY marque
";
$vehicles_result = mysqli_query($connection, $vehicles_query);

if (!$vehicles_result) {
    die("Error in vehicles query: " . mysqli_error($connection));
}

// Retrieve destination options
$destinations_query = "SELECT nom FROM Ville";
$destinations_result = mysqli_query($connection, $destinations_query);

if (!$destinations_result) {
    die("Error in destinations query: " . mysqli_error($connection));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['worker_id']) || empty($_POST['vehicle_id']) || empty($_POST['mission_date']) || empty($_POST['mission_time']) || empty($_POST['destination'])) {
        echo "<script>alert('Please complete all information.'); window.location.href = 'addmission.php';</script>";
        exit();
    }

    $worker_id = $_POST['worker_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $mission_date = $_POST['mission_date'];
    $mission_time = $_POST['mission_time'];
    $destination = $_POST['destination'];

    $insert_mission_query = "INSERT INTO Missions (conducteur_id, service_id, vehicule_id, destination, date_heure, statut)
                             VALUES ('$worker_id', '$user_service', '$vehicle_id', '$destination', '$mission_date $mission_time', 'en attente')";
    $insert_mission_result = mysqli_query($connection, $insert_mission_query);

    if (!$insert_mission_result) {
        die("Error inserting mission: " . mysqli_error($connection));
    }

    $mission_id = mysqli_insert_id($connection);

    // Insert into Reservations table for the driver
    $insert_reservation_query = "INSERT INTO Reservations (mission_id, utilisateur_id, role)
                                 VALUES ('$mission_id', '$worker_id', 'driver')";
    $insert_reservation_result = mysqli_query($connection, $insert_reservation_query);

    if (!$insert_reservation_result) {
        die("Error inserting reservation: " . mysqli_error($connection));
    }

    header("Location: bossdash.php");
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="styles/style.css">
<link rel="stylesheet" href="styles/footer.css">
<link rel="stylesheet" href="styles/addrpoj.css">
<link rel="stylesheet" href="styles/project.css">
<title>home page</title>
</head>
<body>
<div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="main">
    <?php include 'nav.php'; ?>    
    <div class="container-fluid ">
    <form action="addmission.php" method="POST" class="d-flex flex-column gap-3 text-white w-75 m-auto mt-5 p-5">
        <label for="formFile" class="form-label text-black-50 h4">Enter mission information</label>
        <!-- Select worker -->
        <select name="worker_id" class="form-control">
            <option value="">Select driver</option>
            <?php while ($worker = mysqli_fetch_assoc($workers_result)) : ?>
                <option value="<?php echo $worker['utilisateur_id']; ?>"><?php echo $worker['nom_utilisateur']; ?></option>
            <?php endwhile; ?>
        </select>
        <!-- Select vehicle -->
        <select name="vehicle_id" class="form-control">
            <option value="">Select Vehicle</option>
            <?php while ($vehicle = mysqli_fetch_assoc($vehicles_result)) : ?>
                <option value="<?php echo $vehicle['vehicule_id']; ?>"><?php echo $vehicle['marque']; ?></option>
            <?php endwhile; ?>
        </select>
        <!-- Date and time inputs -->
        <input type="date" name="mission_date" class="form-control" placeholder="Date">
        <input type="time" name="mission_time" class="form-control" placeholder="Time">
        <!-- Select destination -->
        <select name="destination" class="form-control">
            <option value="">Select Destination</option>
            <?php while ($destination = mysqli_fetch_assoc($destinations_result)) : ?>
                <option value="<?php echo $destination['nom']; ?>"><?php echo $destination['nom']; ?></option>
            <?php endwhile; ?>
        </select>
        <!-- Description textarea -->
        <!-- <textarea name="description" placeholder="Description" class="form-control" id="myTextarea"></textarea> -->
        <!-- Submit button -->
        <input type="submit" value="Submit" class="btn btn-secondary">
    </form>
    </div>
    </div>
</div>
<?php include 'footer.php'; ?>    
</body>
</html>
