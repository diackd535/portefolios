<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
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
        if (empty($mdp))    $erreurs[] = 'Le mot de passe est obligatoire.';

        // Vérifier si l'email existe déjà
        if (empty($erreurs)) {
            $stmt = $pdo->prepare('SELECT id FROM administrateurs WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->fetch()) $erreurs[] = 'Cet email est déjà utilisé.';
        }

        if (empty($erreurs)) {
            $hash = password_hash($mdp, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('INSERT INTO administrateurs (prenom, nom, email, mot_de_passe) VALUES (?, ?, ?, ?)');
            $stmt->execute([$prenom, $nom, $email, $hash]);
            $succes = 'Administrateur créé avec succès.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un administrateur</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="index.php">← Retour aux administrateurs</a>
</nav>

<main>
    <h1>Ajouter un administrateur</h1>

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
            <input type="text" name="prenom" required>
        </div>
        <div>
            <label>Nom *</label>
            <input type="text" name="nom" required>
        </div>
        <div>
            <label>Email *</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Mot de passe *</label>
            <input type="password" name="mot_de_passe" required>
        </div>

        <button type="submit">Créer</button>
    </form>
</main>

</body>
</html>