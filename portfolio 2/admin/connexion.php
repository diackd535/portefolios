<?php
require_once '../fonctions.php';
require_once '../config/connexion.php';

// Si déjà connecté → rediriger vers dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification CSRF
    if (!verifierCSRF($_POST['csrf'] ?? '')) {
        $erreur = 'Requête invalide. Veuillez réessayer.';
    } else {

        $email = trim($_POST['email'] ?? '');
        $mdp   = $_POST['mot_de_passe'] ?? '';

        // Recherche de l'admin par email
        $stmt = $pdo->prepare('SELECT * FROM administrateurs WHERE email = ?');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        // Vérification mot de passe
        if ($admin && password_verify($mdp, $admin['mot_de_passe'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id']     = $admin['id'];
            $_SESSION['admin_prenom'] = $admin['prenom'];
            header('Location: dashboard.php');
            exit;
        } else {
            $erreur = 'Email ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="connexion-container">
    <h1>Espace Administration</h1>

    <?php if ($erreur): ?>
        <p class="erreur"><?= nettoyer($erreur) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf" value="<?= genererCSRF() ?>">

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>

        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>