<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Initialisation des variables
$depart = $_POST['depart'] ?? null;
$destination = $_POST['destination'] ?? null;
$date_depart = $_POST['date_depart'] ?? null;
$trajets = [];

if ($depart && $destination && $date_depart) {
    try {
        // Recherche des trajets correspondant aux critères
        $stmt = $pdo->prepare("
            SELECT * 
            FROM trajets 
            WHERE depart = ? AND destination = ? AND date_depart = ?
        ");
        $stmt->execute([$depart, $destination, $date_depart]);
        $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des trajets : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres de Trajets</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .offer {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .offer h2 {
            margin: 0 0 10px;
            color: #007BFF; /* Blue for the title */
        }

        .offer p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }

        .offer .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            text-align: center;
            color: white;
            background-color: #28a745; /* Green for button */
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .offer .btn:hover {
            background-color: #218838;
        }

        /* Message for empty results */
        .no-results {
            text-align: center;
            color: #777;
            font-size: 16px;
            padding: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .offer {
                padding: 15px;
            }

            .offer h2 {
                font-size: 18px;
            }

            .offer p {
                font-size: 13px;
            }

            .offer .btn {
                font-size: 13px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Résultats de la Recherche</h1>
        <?php if (!empty($trajets)) { ?>
            <?php foreach ($trajets as $trajet) { ?>
                <div class="offer">
                    <h2>Trajet : <?= htmlspecialchars($trajet['depart']) ?> → <?= htmlspecialchars($trajet['destination']) ?></h2>
                    <p><strong>Date :</strong> <?= htmlspecialchars($trajet['date_depart']) ?></p>
                    <p><strong>Prix :</strong> <?= htmlspecialchars($trajet['prix']) ?> MAD</p>
                    <p><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['conducteur_nom'] ?? 'Inconnu') ?></p>
                    <p><strong>Places disponibles :</strong> <?= htmlspecialchars($trajet['places_disponibles']) ?></p>
                    <a class="btn" href="reservationTrajet.php?id=<?= htmlspecialchars($trajet['id']) ?>">Réserver</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="no-results">Aucun trajet ne correspond à votre recherche.</p>
        <?php } ?>
    </div>
</body>
</html>
