<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - NRV Festival</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Connexion pour le Staff NRV</h2>

    <form action="LoginAction.php" method="post">
        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Se connecter</button>
    </form>

    <?php
    // Message d'erreur si la connexion échoue
    if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
        echo "<p style='color: red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
    }
    ?>

</body>
</html>
