<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM projets ORDER BY date_creation DESC');
$projets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des projets</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../deconnexion.php">Se déconnecter</a>
</nav>

<main>
    <h1>Projets</h1>
    <a href="ajouter.php">+ Ajouter un projet</a>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Technologies</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($projets)): ?>
                <tr><td colspan="4">Aucun projet.</td></tr>
            <?php else: ?>
                <?php foreach ($projets as $projet): ?>
                    <tr>
                        <td><?= nettoyer($projet['titre']) ?></td>
                        <td><?= nettoyer($projet['technologies']) ?></td>
                        <td><?= nettoyer($projet['date_creation']) ?></td>
                        <td>
                            <a href="modifier.php?id=<?= $projet['id'] ?>">Modifier</a>
                            <form method="POST" action="supprimer.php" style="display:inline"
                                  onsubmit="return confirm('Supprimer ce projet ?')">
                                <input type="hidden" name="csrf" value="<?= genererCSRF() ?>">
                                <input type="hidden" name="id" value="<?= $projet['id'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>