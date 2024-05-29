<?php
require 'config.php' ; 
$user_query = "SELECT nom_utilisateur, role FROM Utilisateurs WHERE utilisateur_id = '$user_id'";
$user_resultt = mysqli_query($connection, $user_query);
$users = mysqli_fetch_assoc($user_resultt);
// Assuming $user data is passed from the main file
$user_name = isset($users['nom_utilisateur']) ? $users['nom_utilisateur'] : "oussama";
$role = isset($users['role']) ? $users['role'] : "";

// Function to check if the user is admin
function isAdmin($role) {
    return strtolower($role) === "admin";
}
if (isset($_GET['signout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("Location: seconnect.php");
    exit(); // Ensure script execution stops after redirection
}


?>

<nav class="navbar navbar-expand px-3 border-bottom d-flex justify-content-between">
    <!-- Button for sidebar toggle -->
    <div class="">
        <button class="btn" type="button" data-bs-theme="dark">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>

    <input type="search" class=" w-50 search form-control text-center" id="datatable-search-input" placeholder="search">

    <div class="test  ms-3">
        <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="image/avatar.PNG" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?php echo $user_name; ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1" style="">
            <?php if (isAdmin($role)) : ?>
                <li><a class="dropdown-item" href="bossdash.php">Setting</a></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="seconnect.php">Sign out</a></li>
        </ul>
    </div>

</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="script.js"></script>
