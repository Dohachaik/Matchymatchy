<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Trajet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Réservation de Trajet</h2>
        <form action="index.php?controller=reservation&action=validerReservation" method="POST">
            <!-- Informations sur le trajet -->
            <label for="trajet_id">Trajet ID :</label>
            <input type="text" id="trajet_id" name="trajet_id" value="<?php echo htmlspecialchars($trajet['id']); ?>" readonly>

            <label for="depart">Départ :</label>
            <input type="text" id="depart" name="depart" value="<?php echo htmlspecialchars($trajet['depart']); ?>" readonly>

            <label for="destination">Destination :</label>
            <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($trajet['destination']); ?>" readonly>

            <label for="date_depart">Date de Départ :</label>
            <input type="text" id="date_depart" name="date_depart" value="<?php echo htmlspecialchars($trajet['date_depart']); ?>" readonly>

            <label for="prix">Prix :</label>
            <input type="text" id="prix" name="prix" value="<?php echo htmlspecialchars($trajet['prix']); ?>" readonly>

            <!-- Informations sur la réservation -->
            <label for="utilisateur_nom">Nom du Passager :</label>
            <input type="text" id="utilisateur_nom" name="utilisateur_nom" placeholder="Votre nom complet" required>

            <label for="utilisateur_email">Email du Passager :</label>
            <input type="email" id="utilisateur_email" name="utilisateur_email" placeholder="Votre adresse email" required>

            <label for="date_reservation">Date de Réservation :</label>
            <input type="date" id="date_reservation" name="date_reservation" value="<?php echo date('Y-m-d'); ?>" readonly>

            <label for="paiement_effectue">Paiement :</label>
            <select id="paiement_effectue" name="paiement_effectue" required>
                <option value="1">Effectué</option>
                <option value="0">Non Effectué</option>
            </select>

            <!-- Validation -->
            <button type="submit">Valider la Réservation</button>
        </form>
    </div>
</body>
</html>
