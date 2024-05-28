<?php
// Include database connection file
include 'db_connection.php';

// Retrieve logged-in user's service_id (You need to implement user authentication first)
$user_service_id = "123"; // Example service_id, replace this with actual logged-in user's service_id

// Retrieve workers in the same service
$workers_query = "SELECT utilisateur_id, nom_utilisateur FROM Utilisateurs WHERE service_id = '$user_service_id'";
$workers_result = mysqli_query($connection, $workers_query);

// Retrieve available vehicles
$vehicles_query = "SELECT vehicule_id, marque FROM Vehicules WHERE est_occupe = FALSE";
$vehicles_result = mysqli_query($connection, $vehicles_query);

// Retrieve destination options
$destinations_query = "SELECT nom FROM Ville";
$destinations_result = mysqli_query($connection, $destinations_query);
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
    <form action="create_mission.php" method="POST" class="d-flex flex-column gap-3 text-white w-75 m-auto mt-5 p-5">
        <label for="formFile" class="form-label text-black-50 h4">Enter mission information</label>
        <!-- Select worker -->
        <select name="worker_id" class="form-control">
            <option value="">Select Worker</option>
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
        <textarea name="description" placeholder="Description" class="form-control" id="myTextarea"></textarea>
        <!-- Submit button -->
        <input type="submit" value="Submit" class="btn btn-secondary">
    </form>
                    


              </div>
    </div>
    </div>
    <?php include 'footer.php'; ?>    
  
   
</body>
</html>
<?php
// Include database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields are set and not empty
    if (isset($_POST['worker_id']) && isset($_POST['vehicle_id']) && isset($_POST['mission_date']) && isset($_POST['mission_time']) && isset($_POST['destination']) && isset($_POST['description'])) {
        
        // Retrieve values from the form
        $worker_id = $_POST['worker_id'];
        $vehicle_id = $_POST['vehicle_id'];
        $mission_date = $_POST['mission_date'];
        $mission_time = $_POST['mission_time'];
        $destination = $_POST['destination'];
        $description = $_POST['description'];

        // SQL query to insert the mission into the database
        $sql = "INSERT INTO Missions (service_id, vehicule_id, destination, date_heure, nombre_places_reserves, statut) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Prepare the SQL statement
        $stmt = mysqli_prepare($connection, $sql);
        
        // Check if the SQL statement is prepared successfully
        if ($stmt) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "ssssis", $worker_id, $vehicle_id, $destination, $mission_date . ' ' . $mission_time, $nombre_places_reserves, $statut);
            
            // Set the parameters
            $nombre_places_reserves = 5; // You can set the number of reserved places as needed
            $statut = 'Pending'; // Initial status of the mission
            
            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Mission inserted successfully.";
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "All form fields are required.";
    }
}
?>
