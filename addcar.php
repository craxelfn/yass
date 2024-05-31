<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) ) {
    header("Location: seconnect.php");
    exit();
}
if (!isset($_SESSION['user_service'])) {
    die("vous avez pas in service .");
}

$user_id = $_SESSION['user_id'];
$user_service = $_SESSION['user_service'];


$vehicles_query = "
    SELECT MIN(vehicule_id) AS vehicule_id, marque 
    FROM Vehicules 
    WHERE est_occupe = FALSE 
    GROUP BY marque
";
$vehicles_result = mysqli_query($connection, $vehicles_query);

if (!$vehicles_result) {
    die("Error in vehicles query: " . mysqli_error($connection));
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marque = isset($_POST['marque']) ? $_POST['marque'] : '';
    $marque1 = isset($_POST['marque1']) ? $_POST['marque1'] : '';
    $matricule = $_POST['matricule'];

    if (!empty($marque)) {
        $selectedMarque = $marque;
    } elseif (!empty($marque1)) {
        $selectedMarque = $marque1;
    }  else {
        echo "<div class='alert alert-danger'>
                  <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
                  marque is required
              </div>";
        exit;
    }

    if (empty($matricule)) {
        echo "<script>alert('Matricule is required');</script>";
        exit;
    }

    // Insert into database
    $insert_query = "INSERT INTO Vehicules (vehicule_id, service_id, marque) VALUES ('$matricule', '$user_service', '$selectedMarque')";
    $insert_result = mysqli_query($connection, $insert_query);

    if ($insert_result) {
        echo "Car created successfully.";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
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
    <form action="addcar.php" method="POST" class="d-flex flex-column gap-3 text-white w-75 m-auto mt-5 p-5">
        <label for="formFile" class="form-label text-black-50 h4">Enter voiture information</label>      
        <!-- Select vehicle -->
        <select name="marque1" id="marque1" class="form-control" onchange="toggleNewMarqueInput(this.value)">
            <option value="" selected>Select marque</option>
            <?php while ($vehicle = mysqli_fetch_assoc($vehicles_result)) : ?>
                <option value="<?php echo $vehicle['marque']; ?>"><?php echo $vehicle['marque']; ?></option>
            <?php endwhile; ?>
        </select>
        <!-- New marque input -->
        <input type="text" name="marque" id="new_marque_input" class="form-control" placeholder="New marque">
        <input type="text" name="matricule" class="form-control" placeholder="Matricule">
        <input type="submit" value="Submit" class="btn btn-secondary">
    </form>
    </div>
    </div>
</div>
<?php include 'footer.php'; ?>    

<!-- JavaScript to hide new marque input by default -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var newMarqueInput = document.getElementById('new_marque_input');
    newMarqueInput.style.display = 'block'; // Show by default
});

function toggleNewMarqueInput(selectedValue) {
    var newMarqueInput = document.getElementById('new_marque_input');
    if (selectedValue !== '') {
        newMarqueInput.style.display = 'none'; // Hide if a marque is selected
    } else {
        newMarqueInput.style.display = 'block'; // Show if no marque selected
    }
}




</script>

</body>
</html>


