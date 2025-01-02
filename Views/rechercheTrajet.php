<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Trajet</title>
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
            margin: 10px 0 5px;
            color: #555;
        }

        select, input[type="date"], button {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #008000;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #008000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recherche de Trajet</h1>
        <form action="index.php?controller=passager&action=rechercherTrajet" method="POST">
            <label for="depart">Ville de départ :</label>
            <select id="depart" name="depart" required>
                <option value="" disabled selected>-- Sélectionnez une ville --</option>
                <option value="Casablanca">Casablanca</option>
                <option value="Rabat">Rabat</option>
                <option value="Marrakech">Marrakech</option>
                <option value="Fès">Fès</option>
                <option value="Tanger">Tanger</option>
                <option value="Agadir">Agadir</option>
                <option value="Meknès">Meknès</option>
                <option value="Oujda">Oujda</option>
                <option value="Tetouan">Tétouan</option>
                <option value="Laâyoune">Laâyoune</option>
                <option value="Safi">Safi</option>
                <option value="Essaouira">Essaouira</option>
                <option value="El Jadida">El Jadida</option>
                <option value="Nador">Nador</option>
                <option value="Kénitra">Kénitra</option>
                <option value="Ifrane">Ifrane</option>
                <option value="Taza">Taza</option>
                <option value="Chefchaouen">Chefchaouen</option>
                <option value="Béni Mellal">Béni Mellal</option>
                <option value="Errachidia">Errachidia</option>
                <option value="Guelmim">Guelmim</option>
                <option value="Ouarzazate">Ouarzazate</option>
            </select>

            <label for="destination">Ville de destination :</label>
            <select id="destination" name="destination" required>
                <option value="" disabled selected>-- Sélectionnez une ville --</option>
                <option value="Casablanca">Casablanca</option>
                <option value="Rabat">Rabat</option>
                <option value="Marrakech">Marrakech</option>
                <option value="Fès">Fès</option>
                <option value="Tanger">Tanger</option>
                <option value="Agadir">Agadir</option>
                <option value="Meknès">Meknès</option>
                <option value="Oujda">Oujda</option>
                <option value="Tetouan">Tétouan</option>
                <option value="Laâyoune">Laâyoune</option>
                <option value="Safi">Safi</option>
                <option value="Essaouira">Essaouira</option>
                <option value="El Jadida">El Jadida</option>
                <option value="Nador">Nador</option>
                <option value="Kénitra">Kénitra</option>
                <option value="Ifrane">Ifrane</option>
                <option value="Taza">Taza</option>
                <option value="Chefchaouen">Chefchaouen</option>
                <option value="Béni Mellal">Béni Mellal</option>
                <option value="Errachidia">Errachidia</option>
                <option value="Guelmim">Guelmim</option>
                <option value="Ouarzazate">Ouarzazate</option>
            </select>

            <label for="date_depart">Date de départ :</label>
            <input type="date" id="date_depart" name="date_depart" required>

            <button type="submit">Rechercher</button>
        </form>
    </div>
</body>
</html>
