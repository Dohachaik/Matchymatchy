<?php
class TrajetModel {
    private $db ;
    public function __construct() {
        define('USER', 'root');
        define('PASS', '');
        $this->db = new PDO('mysql:host=localhost;dbname=bd', USER, PASS);
    }
    
    public function getTrajetsAvecConducteur() {
        $query = "SELECT t.*, c.nom AS conducteur_nom 
                  FROM trajets t
                  INNER JOIN conducteurs c ON t.conducteur_id = c.id";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function deleteTrajet($id) {
        $query = "DELETE FROM trajets WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
?>
