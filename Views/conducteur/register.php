<?php
session_start();

// Exemple de logique PHP
$errors = [];
$success = false;

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Gestion du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['contact'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $photo = $_FILES['photo']['name'] ?? null; // Pour le fichier photo
    $cin = filter_var($_POST['cin'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation des champs
    if (empty($nom)) $errors[] = "Le nom est requis";
    if (empty($contact)) $errors[] = "Le contact est requis";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (empty($cin)) $errors[] = "Le CIN est requis";
    if (strlen($password) < 6) $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
    if ($password !== $confirm_password) $errors[] = "Les mots de passe ne correspondent pas";

    // Vérification de l'unicité de l'email et du CIN
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM conducteurs WHERE email = ? OR cin = ?");
            $stmt->execute([$email, $cin]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "L'email ou le CIN est déjà utilisé";
            }
        } catch (PDOException $e) {
            $errors[] = "Une erreur est survenue lors de la vérification des données";
        }
    }

    // Si tout est valide, insérer dans la base de données
    if (empty($errors)) {
        try {
            // Téléversement de la photo
            if ($photo) {
                $upload_dir = 'uploads/';
                $upload_path = $upload_dir . basename($photo);
                move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path);
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO conducteurs (nom, contact, email, photo, cin, password) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$nom, $contact, $email, $photo, $cin, $hashed_password]);
            
            $success = true;
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Une erreur est survenue lors de l'inscription";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Registration</title>
    <style>
        /* Styles identiques à votre CSS précédent */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #00008B;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #00008B;
        }

        button.btn-primary {
            width: 100%;
            background: #00008B;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }

        button.btn-primary:hover {
            background: #ADD8E6;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            color: #721c24;
            background: #f8d7da;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Inscription</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php elseif ($success): ?>
            <div class="alert" style="background: #d4edda; color: #155724;">
                Inscription réussie ! Redirection...
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="form">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact *</label>
                <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($_POST['contact'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo">
            </div>

            <div class="form-group">
                <label for="cin">CIN *</label>
                <input type="text" id="cin" name="cin" value="<?= htmlspecialchars($_POST['cin'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>
</html>
