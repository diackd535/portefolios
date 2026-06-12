<?php
require_once '../../fonctions.php';
require_once '../../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM projets WHERE id = ?');
$stmt->execute([$id]);
$projet = $stmt->fetch();

if (!$projet) {
    header('Location: index.php');
    exit;
}

$erreurs = [];
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifierCSRF($_POST['csrf'] ?? '')) {
        $erreurs[] = 'Requête invalide.';
    } else {

        $titre        = trim($_POST['titre'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $technologies = trim($_POST['technologies'] ?? '');
        $lien         = trim($_POST['lien'] ?? '');
        $image        = $projet['image']; // conserver l'ancienne par défaut

        if (empty($titre))        $erreurs[] = 'Le titre est obligatoire.';
        if (empty($description))  $erreurs[] = 'La description est obligatoire.';
        if (empty($technologies)) $erreurs[] = 'Les technologies sont obligatoires.';

        // Nouvelle image uploadée ?
        if (!empty($_FILES['image']['name'])) {
            $ext_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $ext_autorisees)) {
                $erreurs[] = 'Format image non autorisé.';
            } else {
                $nom_fichier = uniqid('projet_', true) . '.' . $ext;
                $dossier = '../../images/projets/';
                if (!is_dir($dossier)) mkdir($dossier, 0755, true);
                move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $nom_fichier);
                // Supprimer l'ancienne image
                if ($projet['image'] && file_exists($dossier . $projet['image'])) {
                    unlink($dossier . $projet['image']);
                }
                $image = $nom_fichier;
            }
        }

        if (empty($erreurs)) {
            $stmt = $pdo->prepare('UPDATE projets SET titre=?, description=?, technologies=?, image=?, lien=? WHERE id=?');
            $stmt->execute([$titre, $description, $technologies, $image, $lien, $id]);
            $succes = 'Projet modifié avec succès.';
            // Recharger les données
            $stmt = $pdo->prepare('SELECT * FROM projets WHERE id = ?');
            $stmt->execute([$id]);
            $projet = $stmt->fetch();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un projet</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="index.php">← Retour aux projets</a>
</nav>

<main>
    <h1>Modifier le projet</h1>

    <?php foreach ($erreurs as $e): ?>
        <p class="erreur"><?= nettoyer($e) ?></p>
    <?php endforeach; ?>

    <?php if ($succes): ?>
        <p class="succes"><?= nettoyer($succes) ?></p>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= genererCSRF() ?>">

        <div>
            <label>Titre *</label>
            <input type="text" name="titre" value="<?= nettoyer($projet['titre']) ?>" required>
        </div>
        <div>
            <label>Description *</label>
            <textarea name="description" required><?= nettoyer($projet['description']) ?></textarea>
        </div>
        <div>
            <label>Technologies *</label>
            <input type="text" name="technologies" value="<?= nettoyer($projet['technologies']) ?>" required>
        </div>
        <div>
            <label>Lien externe</label>
            <input type="url" name="lien" value="<?= nettoyer($projet['lien'] ?? '') ?>">
        </div>
        <div>
            <label>Image actuelle</label>
            <?php if ($projet['image']): ?>
                <img src="../../images/projets/<?= nettoyer($projet['image']) ?>" width="150">
            <?php else: ?>
                <p>Aucune image</p>
            <?php endif; ?>
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif">
        </div>

        <button type="submit">Enregistrer</button>
    </form>
</main>

</body>
</html>