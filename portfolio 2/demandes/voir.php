<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM demandes_projet WHERE id = ?');
$stmt->execute([$id]);
$demande = $stmt->fetch();

if (!$demande) {
    header('Location: index.php');
    exit;
}

// Marquer comme lu
if (!$demande['lu']) {
    $stmt = $pdo->prepare('UPDATE demandes_projet SET lu = 1 WHERE id = ?');
    $stmt->execute([$id]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de <?= nettoyer($demande['nom']) ?></title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="index.php">← Retour aux demandes</a>
</nav>

<main>
    <h1>Demande de <?= nettoyer($demande['nom']) ?></h1>

    <p><strong>Email :</strong> <?= nettoyer($demande['email']) ?></p>
    <p><strong>Type de projet :</strong> <?= nettoyer($demande['type_projet']) ?></p>
    <p><strong>Budget :</strong> <?= nettoyer($demande['budget'] ?? 'Non précisé') ?></p>
    <p><strong>Date :</strong> <?= nettoyer($demande['date_demande']) ?></p>
    <hr>
    <p><?= nl2br(nettoyer($demande['description'])) ?></p>
</main>

</body>
</html>