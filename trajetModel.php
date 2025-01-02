<?php
class TrajetModel {
    private $db ;
    public function __construct() {
        define('USER', 'root');
        define('PASS', '');
        $this->db = new PDO('mysql:host=localhost;dbname=bd', USER, PASS);
    }
    

    public function ajouterTrajet($conducteur_id, $depart, $destination, $date_depart, $heure_depart, $prix, $type_voiture, $places_disponibles) {
        $query = "INSERT INTO trajets (conducteur_id, depart, destination, date_depart, heure_depart, prix, type_voiture, places_disponibles) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$conducteur_id, $depart, $destination, $date_depart, $heure_depart, $prix, $type_voiture, $places_disponibles]);
    }

    public function getAllTrajets() {
        $query = "SELECT * FROM trajets";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTrajet($id, $conducteur_id, $depart, $destination, $date_depart, $heure_depart, $prix, $type_voiture, $places_disponibles) {
        $query = "UPDATE trajets SET conducteur_id=?, depart=?, destination=?, date_depart=?, heure_depart=?, prix=?, type_voiture=?, places_disponibles=? WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$conducteur_id, $depart, $destination, $date_depart, $heure_depart, $prix, $type_voiture, $places_disponibles, $id]);
    }

    public function deleteTrajet($id) {
        $query = "DELETE FROM trajets WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
?>
