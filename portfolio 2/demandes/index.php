<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM demandes_projet ORDER BY date_demande DESC');
$demandes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes de projet</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../deconnexion.php">Se déconnecter</a>
</nav>

<main>
    <h1>Demandes de projet</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type de projet</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($demandes)): ?>
                <tr><td colspan="5">Aucune demande reçue.</td></tr>
            <?php else: ?>
                <?php foreach ($demandes as $demande): ?>
                    <tr class="<?= $demande['lu'] ? '' : 'non-lu' ?>">
                        <td><?= nettoyer($demande['nom']) ?></td>
                        <td><?= nettoyer($demande['type_projet']) ?></td>
                        <td><?= nettoyer($demande['date_demande']) ?></td>
                        <td><?= $demande['lu'] ? 'Lu' : '<strong>Non lu</strong>' ?></td>
                        <td><a href="voir.php?id=<?= $demande['id'] ?>">Voir</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>