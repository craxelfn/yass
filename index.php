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
    <link rel="stylesheet" href="styles/project.css">
    <title>home page</title>
</head>
<body>
    <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="main">
    <?php include 'nav.php'; ?>    
    <div class="container">
                <form action="" method="POST" class="d-flex gap-1 mt-5 border p-2 ">
                    <select name="destination" class="form-control">
                        <option value="">Destination</option>
                        <?php 
                        // Fetch destinations from the database and populate the dropdown
                        include 'db_connection.php';
                        $destinations_query = "SELECT nom FROM Ville";
                        $destinations_result = mysqli_query($connection, $destinations_query);
                        while ($destination = mysqli_fetch_assoc($destinations_result)) {
                            echo "<option value='" . $destination['nom'] . "'>" . $destination['nom'] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="date" name="mission_date" class="form-control" placeholder="Date maximum">
                    <input type="submit" name="submit" value="Valider" class="btn btn-success ">
                </form>
               <div class="row mt-3">
                <?php 
                // Check if the form is submitted
                if(isset($_POST['submit'])){
                    // Retrieve selected destination and date
                    $selected_destination = $_POST['destination'];
                    $selected_date = $_POST['mission_date'];

                    // Query to fetch missions based on destination and date
                    $missions_query = "SELECT * FROM Missions WHERE destination = '$selected_destination' AND date_heure LIKE '$selected_date%' AND nombre_places_reserves != 0";
                    $missions_result = mysqli_query($connection, $missions_query);

                    // Display missions
                    while ($mission = mysqli_fetch_assoc($missions_result)) {
                        echo "<div class='projects col-lg-6 mt-1 mb-1'>
                                <div class='project1 d-flex justify-content-between pe-1'>
                                    <div class='d-flex gap-3'>
                                        <img src='image/hiluximg.jpg' class='img-fluid p-1 projectimg' alt=''>
                                        <div class='mt-2 desc text-black d-flex flex-column'>
                                            <p class='title'>vehicule marque</p>
                                            <p class='title2'>created by : " . $mission['service_id'] . "</p>
                                            <div class='prix title'>place available : " . $mission['nombre_places_reserves'] . "</div>
                                            <form action='reserve.php' method='POST' class='avatar'>
                                                <input type='hidden' name='mission_id' value='" . $mission['mission_id'] . "'>
                                                <input type='submit' class='btn btn-secondary' value='Reserver'>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                }
                ?>
               </div>
          </div> 
    </div>
    </div>
    <?php include 'footer.php'; ?>    
  
   
</body>
</html>



<?php
// Include database connection file
include 'db_connection.php';

// Check if mission ID is set
if(isset($_POST['mission_id'])){
    // Retrieve mission ID from form submission
    $mission_id = $_POST['mission_id'];

    // Check if utilisateur ID (user ID) is set (You need to implement user authentication to get the user ID)
    $utilisateur_id = 123; // Example utilisateur ID, replace this with actual user ID

    // Insert reservation into Reservations table
    $insert_query = "INSERT INTO Reservations (mission_id, utilisateur_id) VALUES ('$mission_id', '$utilisateur_id')";
    $insert_result = mysqli_query($connection, $insert_query);

    // Check if reservation was inserted successfully
    if($insert_result){
        // Update mission record to decrement nombre_places_reserves by 1
        $update_query = "UPDATE Missions SET nombre_places_reserves = nombre_places_reserves - 1 WHERE mission_id = $mission_id ";
        $update_result = mysqli_query($connection, $update_query);

        // Check if update was successful
        if($update_result){
            // Redirect back to the home page
            header("Location: home.php");
            exit();
        } else {
            // Handle update failure
            echo "Error updating mission. Please try again.";
        }
    } else {
        // Handle insertion failure
        echo "Error inserting reservation. Please try again.";
    }
} else {
    // Handle case where mission ID is not set
    echo "Mission ID not provided.";
}
?>

