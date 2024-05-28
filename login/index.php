<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> S'authentifier </title>
    <link rel="stylesheet" href="style.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img class="frontImg" src="../image/ocpimg.png" alt="">
        <div class="text">
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="../image/ocpimg.png" alt="">
        <div class="text2">
          <span class="text-1">Enrichissez votre carrière <br> Avec une seule étape</span>
          <span class="text-2">Commençer</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">S'authentifier</div>
          <form action="login.php" method="post">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Enterer votre email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enterer votre mot de passe" required>
              </div>
              <div class="text"><a href="motdepasse_oublie.html">Mot de passe oublié?</a></div>
              <div class="button input-box">
                <input type="submit" value="S'authentifier">
              </div>
              <div class="text sign-up-text">Vous n'avez pas de compte? <label for="flip">Créer un compte maintenant</label></div>
            </div>
        </form>
      </div>
        <div class="signup-form">
          <div class="title">Créer votre compte</div>
        <form action="signup.php" method="post">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Enterer votre nom" required>
              </div>
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Enterer votre email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enterer votre mot de passe" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Créer le compte">
              </div>
              <div class="text sign-up-text">Vous avez déja un compte? <label for="flip">Login</label></div>
            </div>
      </form>
    </div>
    </div>
    </div>
  </div>
 <div class="error">
 
 <?php
// Vérifiez si le paramètre GET "error" est défini
if (isset($_GET['error'])) {
    // Récupérez la valeur du paramètre GET "error"
    $error = $_GET['error'];

    // Affichez un message approprié en fonction de la valeur de "error"
    switch ($error) {
        case 'invalid_login':
            echo "<p style='color: red;'>Adresse e-mail ou mot de passe incorrect.</p>";
            break;
        case 'user_not_found':
            echo "<p style='color: red;'>Utilisateur non trouvé.</p>";
            break;
        case 'invalid_request':
            echo "<p style='color: red;'>Requête invalide.</p>";
            break;
        // Ajoutez d'autres cas pour d'autres erreurs si nécessaire
        default:
            echo "<p style='color: red;'>Erreur non spécifiée.</p>";
            break;
    }
}
?>

</div>

  <script>
  // Get the checkbox element for flip
const flipCheckbox = document.getElementById('flip');

// Get the front and back elements
const frontText = document.querySelector('.cover .front .text');
const backText = document.querySelector('.cover .back .text');

// Add event listener to flip checkbox
flipCheckbox.addEventListener('change', function() {
  // Check if the flip checkbox is checked
  if (this.checked) {
    // If checked, hide the front text and show the back text
    frontText.style.opacity = '0';
    backText.style.opacity = '1';
  } else {
    // If unchecked, show the front text and hide the back text
    frontText.style.opacity = '1';
    backText.style.opacity = '0';
  }
});

    </script>
</body>
</html>
