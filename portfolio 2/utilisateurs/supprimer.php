<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!verifierCSRF($_POST['csrf'] ?? '')) {
    header('Location: index.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

// Vérification côté serveur : impossible de supprimer son propre compte
if ($id === $_SESSION['admin_id']) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('DELETE FROM administrateurs WHERE id = ?');
$stmt->execute([$id]);

header('Location: index.php');
exit;