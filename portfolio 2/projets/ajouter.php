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

        $titre        = trim($_POST['titre'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $technologies = trim($_POST['technologies'] ?? '');
        $lien         = trim($_POST['lien'] ?? '');
        $image        = null;

        if (empty($titre))        $erreurs[] = 'Le titre est obligatoire.';
        if (empty($description))  $erreurs[] = 'La description est obligatoire.';
        if (empty($technologies)) $erreurs[] = 'Les technologies sont obligatoires.';

        // Upload image
        if (!empty($_FILES['image']['name'])) {
            $ext_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $ext_autorisees)) {
                $erreurs[] = 'Format image non autorisé (jpg, jpeg, png, webp, gif).';
            } else {
                $nom_fichier = uniqid('projet_', true) . '.' . $ext;
                $dossier = '../../images/projets/';
                if (!is_dir($dossier)) mkdir($dossier, 0755, true);
                move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $nom_fichier);
                $image = $nom_fichier;
            }
        }

        if (empty($erreurs)) {
            $stmt = $pdo->prepare('INSERT INTO projets (titre, description, technologies, image, lien) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$titre, $description, $technologies, $image, $lien]);
            $succes = 'Projet ajouté avec succès.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un projet</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<nav>
    <a href="index.php">← Retour aux projets</a>
</nav>

<main>
    <h1>Ajouter un projet</h1>

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
            <input type="text" name="titre" required>
        </div>
        <div>
            <label>Description *</label>
            <textarea name="description" required></textarea>
        </div>
        <div>
            <label>Technologies *</label>
            <input type="text" name="technologies" required>
        </div>
        <div>
            <label>Lien externe</label>
            <input type="url" name="lien">
        </div>
        <div>
            <label>Image (jpg, jpeg, png, webp, gif)</label>
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif">
        </div>

        <button type="submit">Ajouter</button>
    </form>
</main>

</body>
</html>