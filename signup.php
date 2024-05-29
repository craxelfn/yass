<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $sql = "SELECT * FROM Utilisateurs WHERE email = ?";
    $stmt = $connection ->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: seconnect.php?error=email_exists");
    } else {
        // Insert new user
        $sql = "INSERT INTO Utilisateurs (nom_utilisateur, email, mot_de_passe) VALUES (?, ?, ?)";
        $stmt = $connection ->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);
        
        if ($stmt->execute()) {
            header("Location: seconnect.php?success=account_created");
        } else {
            header("Location: seconnect.php?error=signup_failed");
        }
    }
}
?>
