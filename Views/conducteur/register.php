<?php
session_start();
require_once('../config/database.php');

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'conducteur') {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telephone = filter_var($_POST['telephone'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $numero_permis = filter_var($_POST['numero_permis'], FILTER_SANITIZE_STRING);

    // Validation
    if (empty($nom)) $errors[] = "Le nom est requis";
    if (empty($prenom)) $errors[] = "Le prénom est requis";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (empty($telephone)) $errors[] = "Le numéro de téléphone est requis";
    if (strlen($password) < 6) $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
    if ($password !== $confirm_password) $errors[] = "Les mots de passe ne correspondent pas";
    if (empty($numero_permis)) $errors[] = "Le numéro de permis est requis";

    // Check if email already exists
    try {
        $stmt = $pdo->prepare("SELECT id FROM conducteurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Cet email est déjà utilisé";
        }
    } catch (PDOException $e) {
        $errors[] = "Une erreur est survenue lors de la vérification de l'email";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("
                INSERT INTO conducteurs (nom, prenom, email, telephone, password, numero_permis, date_inscription) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $nom,
                $prenom,
                $email,
                $telephone,
                $hashed_password,
                $numero_permis
            ]);

            $success = true;
            
            // Automatically log in the user
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_type'] = 'conducteur';
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;

            header("Location: dashboard.php");
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
    <title>Inscription Conducteur - Covoiturage</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h1>Inscription Conducteur</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="registration-form">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone *</label>
                <input type="tel" id="telephone" name="telephone" value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="numero_permis">Numéro de permis de conduire *</label>
                <input type="text" id="numero_permis" name="numero_permis" value="<?php echo isset($_POST['numero_permis']) ? htmlspecialchars($_POST['numero_permis']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" id="password" name="password" required>
                <small>Minimum 6 caractères</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>

            <p class="login-link">
                Déjà inscrit ? <a href="login.php">Connectez-vous ici</a>
            </p>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html> 