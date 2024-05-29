<?php
require 'config.php' ; 
$query = "SELECT nom_utilisateur, role FROM Utilisateurs WHERE utilisateur_id = '$user_id'";
$resultt = mysqli_query($connection , $query);
$userss = mysqli_fetch_assoc($resultt);

$rolee = isset($userss['role']) ? $userss['role'] : "";

// Function to check if the user is admin
function isUserAdmin($role) {
    return strtolower($role) === "admin";
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
    <title>sidebar</title>
</head>

<body>
    
   

    <aside id="sidebar">
        <div class=" h-100">
            <div class="sidebar-logo">
                <img src="image/ocpimg.png" class="img-fluid" alt="">
            </div>
            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Service client
                </li>
                <li class="sidebar-item">
                    <a href="index.php" class="sidebar-link">
                        <i class="fa-solid fa-list pe-2"></i>
                        Home
                    </a>
                </li>
                <li class="sidebar-item ">
                    <a href="profile.php" class="sidebar-link">
                        <i class="fa-regular fa-user pe-2"></i>
                        profile
                    </a>
                </li>
                <li class="sidebar-item ">
                    <a href="seconnect.php" class="sidebar-link">
                        <i class="fa-solid  fa-right-from-bracket me-2"></i>
                        sign out
                    </a>
                </li>
                <?php if (isUserAdmin($rolee)) : ?>
                <li class="sidebar-header">
                    Admin space
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi"
                        aria-expanded="false" aria-controls="multi">
                        <i class="fa-solid fa-share-nodes pe-2"></i>
                        Dashboard
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                Admin Panel
                            </a>
                            <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item">
                                    <a href="bossdash.php" class="sidebar-link">control board</a>
                                </li>
                               
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>         
        </div>
    </aside>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <!-- <script src="script.js"></script> -->
</body>

</html>
