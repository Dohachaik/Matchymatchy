<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect based on user type if already logged in
    if ($_SESSION['user_type'] === 'conducteur') {
        header('Location: conducteur/dashboard.php');
        exit;
    } elseif ($_SESSION['user_type'] === 'passager') {
        header('Location: passager/dashboard.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - Service de Covoiturage</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1>Bienvenue sur notre service de covoiturage</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="choice-container">
            <div class="choice-box">
                <h2>Je suis conducteur</h2>
                <p>Proposez des trajets et gagnez de l'argent</p>
                <div class="button-group">
                    <a href="conducteur/login.php" class="btn btn-primary">Connexion</a>
                    <a href="conducteur/register.php" class="btn btn-secondary">Inscription</a>
                </div>
            </div>

            <div class="choice-box">
                <h2>Je suis passager</h2>
                <p>Trouvez un trajet à petit prix</p>
                <div class="button-group">
                    <a href="passager/rechercherTrajet.php" class="btn btn-primary">Rechercher un trajet</a>
                    
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>