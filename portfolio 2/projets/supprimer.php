<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

// Suppression uniquement via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!verifierCSRF($_POST['csrf'] ?? '')) {
    header('Location: index.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

// Récupérer l'image avant suppression
$stmt = $pdo->prepare('SELECT image FROM projets WHERE id = ?');
$stmt->execute([$id]);
$projet = $stmt->fetch();

if ($projet) {
    // Supprimer l'image du serveur
    if ($projet['image']) {
        $chemin = '../../images/projets/' . $projet['image'];
        if (file_exists($chemin)) unlink($chemin);
    }
    // Supprimer de la base
    $stmt = $pdo->prepare('DELETE FROM projets WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;