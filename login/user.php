<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Page utilisateur</title>
</head>
<body>
    <h1>Bienvenue, utilisateur!</h1>
    <button onclick="confirmLogout()">Déconnexion</button>

    <script>
        function confirmLogout() {
            if (confirm("Voulez-vous vraiment vous déconnecter?")) {
                window.location.href = "index.html";
            }
        }
    </script>
</body>
</html>
