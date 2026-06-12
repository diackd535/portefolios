<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM messages_contact ORDER BY date_envoi DESC');
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages de contact</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../deconnexion.php">Se déconnecter</a>
</nav>

<main>
    <h1>Messages de contact</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($messages)): ?>
                <tr><td colspan="5">Aucun message reçu.</td></tr>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <tr class="<?= $msg['lu'] ? '' : 'non-lu' ?>">
                        <td><?= nettoyer($msg['nom']) ?></td>
                        <td><?= nettoyer($msg['email']) ?></td>
                        <td><?= nettoyer($msg['date_envoi']) ?></td>
                        <td><?= $msg['lu'] ? 'Lu' : '<strong>Non lu</strong>' ?></td>
                        <td><a href="voir.php?id=<?= $msg['id'] ?>">Voir</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>