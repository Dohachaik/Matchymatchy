<?php
session_start();

// Configuration de la base de données (ajustez si nécessaire)
$host = 'localhost';
$dbname = 'bd';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Si déjà connecté, redirection vers le tableau de bord
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'conducteur') {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Gestion du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        // Requête pour récupérer le conducteur par email
        $stmt = $pdo->prepare("SELECT id, nom, prenom, password FROM conducteurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Vérification du mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // Stocker les informations dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = 'conducteur';
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];

            // Redirection vers le tableau de bord
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        $error = "Une erreur est survenue. Veuillez réessayer plus tard.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Conducteur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            color: #555;
        }
        input[type="email"], input[type="password"] {
            padding: 10px;
            font-size: 16px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            font-size: 16px;
            background-color: #00008B;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #00008B;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion Conducteur</h1>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
