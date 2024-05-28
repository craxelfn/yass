<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Page admin</title>
</head>
<body>
    <h1>Bienvenue, administrateur!</h1>
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
