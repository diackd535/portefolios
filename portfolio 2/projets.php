<?php
require 'fonctions.php';
require 'config/connexion.php';
enregistrerVisite($pdo, 'projets');

$mot_cle = trim($_GET['q'] ?? '');

// Recherche depuis la base de données
if ($mot_cle !== '') {
    $stmt = $pdo->prepare('SELECT * FROM projets WHERE titre LIKE ? OR description LIKE ? ORDER BY date_creation DESC');
    $terme = '%' . $mot_cle . '%';
    $stmt->execute([$terme, $terme]);
} else {
    $stmt = $pdo->query('SELECT * FROM projets ORDER BY date_creation DESC');
}

$resultats = $stmt->fetchAll();

if ($mot_cle === '') {
    $project_search_message = 'Tapez un mot-clé pour filtrer les projets.';
} elseif (empty($resultats)) {
    $project_search_message = 'Aucun projet ne correspond à votre recherche.';
} else {
    $count = count($resultats);
    $project_search_message = "$count projet" . ($count > 1 ? 's' : '') . " trouvé" . ($count > 1 ? 's' : '') . ".";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Projets présentés par Djiby : sites responsives, applications JavaScript et systèmes PHP.">
    <title>Projets | Djiby Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php require 'composants/navigation.php'; ?>

<main>
    <section class="section section-intro">
        <div class="container">
            <span class="eyebrow">Portfolio</span>
            <h1>Mes projets présentés</h1>
            <p>Découvrez des réalisations conçues pour être claires, performantes et faciles à utiliser.</p>
        </div>
    </section>

    <section class="section section-light">
        <div class="container">
            <form class="search-form" method="GET" action="projets.php" aria-label="Recherche de projets">
                <label for="project-search">Rechercher un projet par mot-clé</label>
                <div class="search-group">
                    <input id="project-search" name="q" type="search"
                           value="<?= nettoyer($mot_cle) ?>"
                           placeholder="Ex : responsive, PHP, application">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
                <p class="search-results"><?= nettoyer($project_search_message) ?></p>
            </form>

            <div class="project-grid">
                <?php if (empty($resultats)): ?>
                    <p class="search-results"><?= nettoyer($project_search_message) ?></p>
                <?php else: ?>
                    <?php foreach ($resultats as $projet): ?>
                        <article class="card project-card">
                            <?php if ($projet['image']): ?>
                                <img src="images/projets/<?= nettoyer($projet['image']) ?>"
                                     alt="<?= nettoyer($projet['titre']) ?>">
                            <?php endif; ?>
                            <div class="card-content">
                                <h3><?= nettoyer($projet['titre']) ?></h3>
                                <p><?= nettoyer($projet['description']) ?></p>
                                <p class="tech"><?= nettoyer($projet['technologies']) ?></p>
                                <?php if ($projet['lien']): ?>
                                    <a href="<?= nettoyer($projet['lien']) ?>" target="_blank"
                                       rel="noreferrer" class="btn btn-secondary">Voir le projet</a>
                                <?php endif; ?>
                                <a href="contact.php" class="btn btn-secondary">Me contacter</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php require 'composants/pied-de-page.php'; ?>
</body>
</html>