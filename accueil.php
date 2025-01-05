<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
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
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .hero {
            background: linear-gradient(to right, #00008B, #00008B);
            color: white;
            text-align: center;
            padding: 50px 20px;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            text-align: center;
        }

        .choice-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .choice-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .choice-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .choice-box h2 {
            font-size: 1.5rem;
            color: #00008B;
            margin-bottom: 10px;
        }

        .choice-box p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }

        .button-group a {
            display: inline-block;
            text-decoration: none;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primary {
            background: #00008B;
            color: white;
        }

        .btn-primary:hover {
            background: #00008B;
            transform: scale(1.05);
        }

        .btn-secondary {
            background: #f44336;
            color: white;
        }

        .btn-secondary:hover {
            background: #c62828;
            transform: scale(1.05);
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            color: #721c24;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-content">
            <h1>Bienvenue sur notre service de covoiturage</h1>
            <p>Simplifiez vos trajets, économisez du temps et de l'argent !</p>
        </div>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_SESSION['error']); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="choice-container">
            <div class="choice-box">
                <h2>Je suis conducteur</h2>
                <p>Proposez des trajets et gagnez de l'argent</p>
                <div class="button-group">
                    <a href="login.php" class="btn btn-primary">Connexion</a>
                    <a href="register.php" class="btn btn-secondary">Inscription</a>
                </div>
            </div>

            <div class="choice-box">
                <h2>Je suis passager</h2>
                <p>Trouvez un trajet à petit prix</p>
                <div class="button-group">
                    <a href="rechercheTrajet.php" class="btn btn-primary">Rechercher un trajet</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
