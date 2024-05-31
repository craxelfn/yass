<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: seconnect.php");
    exit();
}
$user_id = $_SESSION['user_id'];

include 'db_connection.php';
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
    <link rel="stylesheet" href="styles/project.css">
    <title>Home Page</title>
</head>
<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="main">
            <?php include 'nav.php'; ?>    
            <div class="container">
                <form action="" method="POST" class="d-flex gap-1 mt-5 border p-2">
                    <select name="destination" class="form-control">
                        <option value="">Destination</option>
                        <?php 
                        // Fetch destinations from the database and populate the dropdown
                        $destinations_query = "SELECT nom FROM Ville";
                        $destinations_result = mysqli_query($connection, $destinations_query);
                        while ($destination = mysqli_fetch_assoc($destinations_result)) {
                            echo "<option value='" . htmlspecialchars($destination['nom']) . "'>" . htmlspecialchars($destination['nom']) . "</option>";
                        }
                        ?>
                    </select>
                    <input type="date" name="mission_date" class="form-control" placeholder="Date maximum">
                    <input type="submit" name="submit" value="Valider" class="btn btn-success">
                </form>
                <div class="row mt-3">
                <?php 
                // Check if the form is submitted
                if (isset($_POST['submit'])) {
                    // Securely retrieve form inputs
                    $selected_destination = mysqli_real_escape_string($connection, $_POST['destination']);
                    $selected_date = mysqli_real_escape_string($connection, $_POST['mission_date']);

                    // Update old missions
                    $update_old_missions_query = "UPDATE Missions SET est_supprimer = 1, deletedby = 'systeme' WHERE date_heure < CURDATE()";
                    $stmt_update_old_missions = mysqli_prepare($connection, $update_old_missions_query);
                    mysqli_stmt_execute($stmt_update_old_missions);

                    // Query to fetch missions based on destination and date
                    $missions_query = "SELECT m.*, v.marque 
                                       FROM Missions m
                                       JOIN Vehicules v ON m.vehicule_id = v.vehicule_id
                                       WHERE m.destination = ? 
                                         AND m.date_heure LIKE ? 
                                         AND m.nombre_places_reserves != 0 
                                         AND m.est_supprimer = 0";
                    $stmt = mysqli_prepare($connection, $missions_query);
                    $like_date = $selected_date . '%';
                    mysqli_stmt_bind_param($stmt, "ss", $selected_destination, $like_date);
                    mysqli_stmt_execute($stmt);
                    $missions_result = mysqli_stmt_get_result($stmt);

                    // Display missions
                    while ($mission = mysqli_fetch_assoc($missions_result)) {
                        // Construct image path based on the marque
                        $marque_without_spaces = str_replace(' ', '', $mission['marque']);
                        $image_path = "image/" . $marque_without_spaces . ".png";

                        echo "<div class='projects col-lg-6 mt-1 mb-4'>
                                <div class='project1 d-flex justify-content-between pe-1'>
                                    <div class='d-flex gap-3'>
                                        <img src='" . htmlspecialchars($image_path) . "' class='img-fluid p-1 projectimg' alt=''>
                                        <div class='mt-2 desc text-black d-flex flex-column'>
                                            <p class='title'>created by : " . htmlspecialchars($mission['service_id']) . "</p>
                                            <p class='title'>" . htmlspecialchars($mission['date_heure']) . "</p>
                                            <div class='prix title'>place available : " . htmlspecialchars($mission['nombre_places_reserves']) . "</div>
                                            <form action='reserve.php' method='POST' class='avatar'>
                                                <input type='hidden' name='mission_id' value='" . htmlspecialchars($mission['mission_id']) . "'>
                                                <input type='submit' class='btn btn-secondary' value='Reserver'>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                              </div>";
                    }
                    mysqli_stmt_close($stmt);
                }
                ?>
                </div>
            </div> 
        </div>
    </div>
    <?php include 'footer.php'; ?>    
</body>
</html>
