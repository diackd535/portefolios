<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM messages_contact WHERE id = ?');
$stmt->execute([$id]);
$msg = $stmt->fetch();

if (!$msg) {
    header('Location: index.php');
    exit;
}

// Marquer comme lu
if (!$msg['lu']) {
    $stmt = $pdo->prepare('UPDATE messages_contact SET lu = 1 WHERE id = ?');
    $stmt->execute([$id]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Message de <?= nettoyer($msg['nom']) ?></title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="index.php">← Retour aux messages</a>
</nav>

<main>
    <h1>Message de <?= nettoyer($msg['nom']) ?></h1>

    <p><strong>Email :</strong> <?= nettoyer($msg['email']) ?></p>
    <p><strong>Date :</strong> <?= nettoyer($msg['date_envoi']) ?></p>
    <hr>
    <p><?= nl2br(nettoyer($msg['message'])) ?></p>
</main>

</body>
</html>