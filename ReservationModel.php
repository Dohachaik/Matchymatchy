<?php
class ReservationModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=bd', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Ajouter une réservation
    public function ajouterReservation($trajet_id, $utilisateur_nom, $utilisateur_email, $montant) {
        $query = "INSERT INTO reservations (trajet_id, utilisateur_nom, utilisateur_email, montant) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$trajet_id, $utilisateur_nom, $utilisateur_email, $montant]);
    }

    // Récupérer toutes les réservations
    public function getAllReservations() {
        $query = "SELECT * FROM reservations";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
