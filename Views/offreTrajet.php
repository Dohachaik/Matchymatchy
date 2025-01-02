<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Offres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .offer {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .offer h2 {
            margin: 0;
            color: #008000; /* Vert pour le titre */
        }
        .offer p {
            margin: 5px 0;
            color: #555;
        }
        .offer .btn {
            display: inline-block;
            padding: 10px 15px;
            color: white;
            background-color: #FF0000; /* Rouge pour bouton réserver */
            text-decoration: none;
            border-radius: 5px;
        }
        .offer .btn:hover {
            background-color: #cc0000;
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
                    <p><strong>Date :</strong> <?= htmlspecialchars($trajet['date_depart']) ?> à <?= htmlspecialchars($trajet['heure_depart']) ?></p>
                    <p><strong>Prix :</strong> <?= htmlspecialchars($trajet['prix']) ?> MAD</p>
                    <p><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['conducteur_nom']) ?></p>
                    <p><strong>Places restantes :</strong> <?= htmlspecialchars($trajet['places_restantes']) ?></p>
                    <a class="btn" href="index.php?controller=reservation&action=formulaireReservation&id=<?= htmlspecialchars($trajet['id']) ?>">Réserver</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucun trajet ne correspond à votre recherche.</p>
        <?php } ?>
    </div>
</body>
</html>
