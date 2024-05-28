<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging statement to inspect POST data

    // Check if all required fields are set in $_POST array
    if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Debugging statement to inspect hashed password
        echo "Hashed Password: " . $hashed_password;

        // Insert user into database
        $sql = "INSERT INTO users (name, email, password, account_type) VALUES ('$name', '$email', '$hashed_password', 'user')";
        if ($conn->query($sql) === TRUE) {
            // Redirect to login page
            echo "Compte créé avec succes, vous pouvez se connecter";
            sleep(3);
            header("Location: index.html");
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Touts les champs sont obligatoires";
        sleep(5);
        header("Location: index.html");
    }
}
?>
