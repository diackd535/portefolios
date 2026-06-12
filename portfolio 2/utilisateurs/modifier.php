<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM administrateurs WHERE id = ?');
$stmt->execute([$id]);
$admin = $stmt->fetch();

if (!$admin) {
    header('Location: index.php');
    exit;
}

$erreurs = [];
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifierCSRF($_POST['csrf'] ?? '')) {
        $erreurs[] = 'Requête invalide.';
    } else {

        $prenom = trim($_POST['prenom'] ?? '');
        $nom    = trim($_POST['nom'] ?? '');
        $email  = trim($_POST['email'] ?? '');
        $mdp    = $_POST['mot_de_passe'] ?? '';

        if (empty($prenom)) $erreurs[] = 'Le prénom est obligatoire.';
        if (empty($nom))    $erreurs[] = 'Le nom est obligatoire.';
        if (empty($email) || !valider_email($email)) $erreurs[] = 'Email invalide.';

        // Vérifier email unique (sauf pour lui-même)
        if (empty($erreurs)) {
            $stmt = $pdo->prepare('SELECT id FROM administrateurs WHERE email = ? AND id != ?');
            $stmt->execute([$email, $id]);
            if ($stmt->fetch()) $erreurs[] = 'Cet email est déjà utilisé.';
        }

        if (empty($erreurs)) {
            // Mot de passe : si vide on garde l'ancien hash
            if (!empty($mdp)) {
                $hash = password_hash($mdp, PASSWORD_BCRYPT);
            } else {
                $hash = $admin['mot_de_passe'];
            }

            $stmt = $pdo->prepare('UPDATE administrateurs SET prenom=?, nom=?, email=?, mot_de_passe=? WHERE id=?');
            $stmt->execute([$prenom, $nom, $email, $hash, $id]);
            $succes = 'Administrateur modifié avec succès.';

            // Recharger
            $stmt = $pdo->prepare('SELECT * FROM administrateurs WHERE id = ?');
            $stmt->execute([$id]);
            $admin = $stmt->fetch();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un administrateur</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="index.php">← Retour aux administrateurs</a>
</nav>

<main>
    <h1>Modifier l'administrateur</h1>

    <?php foreach ($erreurs as $e): ?>
        <p class="erreur"><?= nettoyer($e) ?></p>
    <?php endforeach; ?>

    <?php if ($succes): ?>
        <p class="succes"><?= nettoyer($succes) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf" value="<?= genererCSRF() ?>">

        <div>
            <label>Prénom *</label>
            <input type="text" name="prenom" value="<?= nettoyer($admin['prenom']) ?>" required>
        </div>
        <div>
            <label>Nom *</label>
            <input type="text" name="nom" value="<?= nettoyer($admin['nom']) ?>" required>
        </div>
        <div>
            <label>Email *</label>
            <input type="email" name="email" value="<?= nettoyer($admin['email']) ?>" required>
        </div>
        <div>
            <label>Nouveau mot de passe <small>(laisser vide pour ne pas changer)</small></label>
            <input type="password" name="mot_de_passe">
        </div>

        <button type="submit">Enregistrer</button>
    </form>
</main>

</body>
</html>