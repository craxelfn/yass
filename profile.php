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


// Handle profile update
if (isset($_POST['save'])) {
    $update_query = "UPDATE Utilisateurs SET ";
    $updates = [];

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $new_name = $_POST['name'];
        $updates[] = "nom_utilisateur = '$new_name'";
    }
    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        $new_phone = $_POST['phone'];
        $updates[] = "phone_num = '$new_phone'";
    }
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $new_email = $_POST['email'];
        $updates[] = "email = '$new_email'";
    }

    if (!empty($updates)) {
        $update_query .= implode(", ", $updates);
        $update_query .= " WHERE utilisateur_id = '$user_id'";
        mysqli_query($connection, $update_query);
    }

    header("Location: profile.php");
    exit();
}



// Handle password change
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current password from database
    $password_query = "SELECT mot_de_passe FROM Utilisateurs WHERE utilisateur_id = '$user_id'";
    $password_result = mysqli_query($connection, $password_query);
    $user_data = mysqli_fetch_assoc($password_result);
    $current_password = $user_data['mot_de_passe'];

    if (password_verify($old_password, $current_password)) {
        if ($new_password === $confirm_password) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_password_query = "UPDATE Utilisateurs SET mot_de_passe = '$new_password_hash' WHERE utilisateur_id = '$user_id'";
            mysqli_query($connection, $update_password_query);
            echo "<script>alert('Password changed successfully!');</script>";
        } else {
            echo "<script>alert('New password and confirm password do not match!');</script>";
        }
    } else {
        echo "<script>alert('Old password is incorrect!');</script>";
    }
}

// Handle avatar change
if (isset($_POST['change_avatar'])) {
    $avatar = $_FILES['avatar']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($avatar);
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    $update_avatar_query = "UPDATE Utilisateurs SET user_image = '$target_file' WHERE utilisateur_id = '$user_id'";
    mysqli_query($connection, $update_avatar_query);
    header("Location: profile.php");
    exit();
}

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
                <div class="row">
                    <div class="col-lg-5 mb-5 profile1 text-center">
                        <div class="cart">
                            <div class="cart-body d-flex flex-column">
                            <?php $image_path = $user['user_image'] ? 'image/' . $user['user_image'] : 'image/avatar.PNG';?>
                                <img src="<?php echo $image_path; ?>" alt="" class="img-fluid mt-3 mb-5">
                                <div class="d-flex justify-content-between text-black">
                                    <h5>My Profile</h5>
                                    <h6 class="w-50 text-black-50">If you want to change any information:</h6>
                                </div>
                                <form class="mt-4 d-flex flex-column" action="profile.php" method="POST">
                                    <div class="d-flex justify-content-between gap-4">
                                        <input type="text" name="name" placeholder="<?php echo $user['nom_utilisateur']; ?>" class="form-control">
                                        <input type="text" name="phone" placeholder="<?php echo $user['phone_num']; ?>" class="form-control">
                                    </div>
                                    <input type="email" name="email" class="form-control mt-2" placeholder="<?php echo $user['email']; ?>">
                                    <input type="submit" value="Confirm" class="btn btn-primary mt-3 w-50" name="save">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-6 d-flex flex-column text-center profile1">
                        <div class="h-50 mt-4"> 
                            <form class="d-flex flex-column gap-3 text-black" action="profile.php" method="POST">
                                <label class="mb-3 mt-5 text-black-50" for="">Change Password</label>
                                <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                                <input type="password" name="new_password" class="form-control" placeholder="New Password">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                <input type="submit" class="btn btn-primary mb-5" value="Confirm" name="change_password">
                            </form>
                        </div>
                        <div class="h-50 mb-4">
                            <form action="profile.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-4 mb-5">
                                <label class="text-black-50" for="">Change Avatar:</label>
                                <input type="file" name="avatar" accept="image/*" class="form-control">
                                <input type="submit" class="btn btn-primary mb-4" value="Modify" name="change_avatar">
                            </form>
                        </div>
                    </div>
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
