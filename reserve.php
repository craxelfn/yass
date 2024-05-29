<?php
session_start();
require 'config.php';

// Check if mission ID is set and user is logged in
if(isset($_POST['mission_id']) && isset($_SESSION['user_id'])){
    // Retrieve mission ID from form submission
    $mission_id = $_POST['mission_id'];
    // Retrieve user ID from session
    $utilisateur_id = $_SESSION['user_id'];

    // Check if the user has already reserved this mission
    $check_query = "SELECT * FROM Reservations WHERE mission_id = '$mission_id' AND utilisateur_id = '$utilisateur_id'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // User has already reserved this mission
        echo "<script>alert('You have already reserved this mission.'); window.location.href='home.php';</script>";
    } else {
        // Insert reservation into Reservations table
        $insert_query = "INSERT INTO Reservations (mission_id, utilisateur_id) VALUES ('$mission_id', '$utilisateur_id')";
        $insert_result = mysqli_query($connection, $insert_query);

        // Check if reservation was inserted successfully
        if($insert_result){
            // Update mission record to decrement nombre_places_reserves by 1
            $update_query = "UPDATE Missions SET nombre_places_reserves = nombre_places_reserves - 1 WHERE mission_id = $mission_id";
            $update_result = mysqli_query($connection, $update_query);

            // Check if update was successful
            if($update_result){
                // Redirect back to the home page
                header("Location: index.php");
                exit();
            } else {
                // Handle update failure
                echo "Error updating mission. Please try again.";
            }
        } else {
            // Handle insertion failure
            echo "Error inserting reservation. Please try again.";
        }
    }
} else {
    // Handle case where mission ID is not set or user is not logged in
    echo "Mission ID not provided or user not logged in.";
}
?>
