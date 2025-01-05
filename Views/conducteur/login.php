<?php
session_start();
require_once('../config/database.php');

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'conducteur') {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT id, nom, prenom, password FROM conducteurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = 'conducteur';
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];

            // Redirect to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    } catch (PDOException $e) {
        $error = "Une erreur est survenue. Veuillez réessayer plus tard.";
    }
}
?>

<!DOCTYPE