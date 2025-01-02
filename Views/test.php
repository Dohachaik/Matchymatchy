<?php
require_once 'models/TrajetModel.php';

$trajetModel = new TrajetModel();

// Récupérer les trajets avec les informations du conducteur
$trajets = $trajetModel->getTrajetsAvecConducteur();

// Inclure la vue pour afficher les trajets
require 'offreTrajet.php';
