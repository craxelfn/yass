<?php
session_start();
require 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: seconnect.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user information
$user_query = "SELECT nom_utilisateur, phone_num, user_image, email FROM Utilisateurs WHERE utilisateur_id = '$user_id'";
$user_result = mysqli_query($connection, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch user reservations
$reservations_query = "SELECT Missions.mission_id, Missions.destination, Missions.date_heure, Reservations.role
                      FROM Reservations 
                      JOIN Missions ON Reservations.mission_id = Missions.mission_id 
                      WHERE Reservations.utilisateur_id = '$user_id' AND est_supprimer = 0" ;
$reservations_result = mysqli_query($connection, $reservations_query);










if (isset($_POST['delete_reservation'])) {
    $mission_id = $_POST['mission_id'];
    $role = $_POST['role'];

    if ($role == 'driver') {
        // Prepare and execute the query to delete reservations
        $delete_reservations_query = "DELETE FROM Reservations WHERE mission_id = ?";
        $stmt_delete_reservations = $connection->prepare($delete_reservations_query);
        $stmt_delete_reservations->bind_param("i", $mission_id);
        $stmt_delete_reservations->execute();

        // Prepare and execute the query to delete the corresponding mission
        $update_mission_query = "UPDATE Missions SET est_supprimer = 1, deletedby = ? WHERE mission_id = ?";
        $stmt_update_mission = $connection->prepare($update_mission_query);
        $stmt_update_mission->bind_param("si", $user_id, $mission_id);
        $stmt_update_mission->execute();
    } else {
        // Update the mission's reserved places count
        $update_mission_query = "UPDATE Missions SET nombre_places_reserves = nombre_places_reserves + 1 WHERE mission_id = ?";
        $stmt_update_mission = $connection->prepare($update_mission_query);
        $stmt_update_mission->bind_param("i", $mission_id);
        $stmt_update_mission->execute();

        // Prepare and execute the query to delete the reservation for the current user and mission
        $delete_reservation_query = "DELETE FROM Reservations WHERE utilisateur_id = ? AND mission_id = ?";
        $stmt_delete_reservation = $connection->prepare($delete_reservation_query);
        $stmt_delete_reservation->bind_param("ii", $user_id, $mission_id);
        $stmt_delete_reservation->execute();
    }

    // Redirect to profile page after deleting reservation
    header("Location: profile.php");
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
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/boss-dash.css">
    <title>Profile Page</title>
</head>
<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="main">
            <?php include 'nav.php'; ?>    
            <div class="container-fluid mt-5 p-5">
                <h4 class="text-black-50 text-center"> Welcome this is your mission</h4>
                <div class="row">
                   
                    <div class="container mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card crudtab">
                                    <div class="card-header">
                                        <h4 class="mt-2 text-black">My Reservations:</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center custom-table">
                                            <thead>
                                                <tr>
                                                    <th>Destination</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($reservation = mysqli_fetch_assoc($reservations_result)): ?>
                                                <tr>
                                                    <td><?php echo $reservation['destination']; ?></td>
                                                    <td><?php echo date('Y-m-d', strtotime($reservation['date_heure'])); ?></td>
                                                    <td><?php echo date('H:i', strtotime($reservation['date_heure'])); ?></td>
                                                    <td><?php echo $reservation['role']; ?></td>
                                                    <td class="d-flex gap-2">
                                                    
                                                        <form action="profile.php" method="POST" class="d-inline">
                                                            <input type="hidden" name="mission_id" value="<?php echo $reservation['mission_id']; ?>">
                                                            <input type="hidden" name="role" value="<?php echo $reservation['role']; ?>">
                                                            <button type="submit" name="delete_reservation" class="btn btn-danger btn-sm mb-2">Cancel</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <?php include 'footer.php'; ?>    
</body>
</html>
