<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['account_type']=="admin"){
            if ($password == $row['password']) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['account_type'] = $row['account_type'];
                header("Location: admin.php");
                exit();
            } else {
                // Invalid password
                header("Location: index.php?error=invalid_login");
                exit();
            }
        }
        // Verify password
        else if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['account_type'] = $row['account_type'];

            // Redirect based on account type
            if ($row['account_type'] == 'admin') {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: user.php");
                exit();
            }
        } else {
            // Invalid password
            header("Location: index.php?error=invalid_login");
            exit();
        }
    } else {
        // User not found
        header("Location: index.php?error=user_not_found");
        exit();
    }
} else {
    // Si la requête n'est pas de type POST
    // Redirigez vers la page de connexion avec un message d'erreur approprié
    header("Location: index.php?error=invalid_request");
    exit();
}
?>
