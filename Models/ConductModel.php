<?php
class ConductModel {
    private $db;
// connexion base de donnees
    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=bd', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Ajouter un conducteur
    public function addConducteur($nom, $contact, $email, $photo, $cin, $password) {
        $query = "INSERT INTO conducteurs (nom, contact, email, photo, cin, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nom, $contact, $email, $photo, $cin, password_hash($password, PASSWORD_DEFAULT)]);
    }

    // Se connecter en tant que conducteur
    public function loginConducteur($email, $password) {
        $query = "SELECT * FROM conducteurs WHERE email=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $conducteur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($conducteur && password_verify($password, $conducteur['password'])) {
            return $conducteur;
        }
        return null;
    }
}
?>
