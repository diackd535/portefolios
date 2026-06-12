<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$stmt = $pdo->query('SELECT id, prenom, nom, email, date_creation FROM administrateurs ORDER BY date_creation DESC');
$admins = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des administrateurs</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../deconnexion.php">Se déconnecter</a>
</nav>

<main>
    <h1>Administrateurs</h1>
    <a href="ajouter.php">+ Ajouter un administrateur</a>

    <table>
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($admins)): ?>
                <tr><td colspan="5">Aucun administrateur.</td></tr>
            <?php else: ?>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?= nettoyer($admin['prenom']) ?></td>
                        <td><?= nettoyer($admin['nom']) ?></td>
                        <td><?= nettoyer($admin['email']) ?></td>
                        <td><?= nettoyer($admin['date_creation']) ?></td>
                        <td>
                            <a href="modifier.php?id=<?= $admin['id'] ?>">Modifier</a>

                            <?php if ($admin['id'] !== $_SESSION['admin_id']): ?>
                                <form method="POST" action="supprimer.php" style="display:inline"
                                      onsubmit="return confirm('Supprimer cet administrateur ?')">
                                    <input type="hidden" name="csrf" value="<?= genererCSRF() ?>">
                                    <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                                    <button type="submit">Supprimer</button>
                                </form>
                            <?php else: ?>
                                <span>(compte actif)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>