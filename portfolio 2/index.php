<?php
require 'fonctions.php';
require 'config/connexion.php';
enregistrerVisite($pdo, 'accueil');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio de Djiby - développeur web spécialisé en sites modernes, responsive et performants.">
    <title>Accueil | Djiby Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php require 'composants/navigation.php'; ?>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-copy">
                <div class="hero-profile">
                    <img src="./profil.jpg" alt="Photo de profil de Djiby" class="profile-img">
                    <div>
                        <p class="hero-name">Djiby</p>
                        <p class="hero-bio">Développeur web full-stack, je conçois des sites clairs, accessibles et rapides.</p>
                    </div>
                </div>
                <p class="eyebrow">Portfolio développeur web</p>
                <h1>Je crée des sites modernes,<br>rapides et accessibles.</h1>
                <p class="hero-text">Je suis Djiby, développeur web passionné. J’accompagne les projets en combinant design clair, performances optimisées et expérience mobile fluide.</p>
                <div class="hero-actions">
                    <a href="projets.php" class="btn btn-primary">Voir mes projets</a>
                    <a href="contact.php" class="btn btn-secondary">Me contacter</a>
                </div>
                <div class="hero-stats">
                    <div>
                        <strong>3+</strong>
                        <span>projets présentés</span>
                    </div>
                    <div>
                        <strong>HTML</strong>
                        <span>CSS</span>
                    </div>
                    <div>
                        <strong>Responsive</strong>
                        <span>mobile & desktop</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-light">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Présentation</span>
                <h2>Ce que je propose</h2>
            </div>
            <div class="grid grid-3">
                <article class="feature-card">
                    <h3>Sites responsives</h3>
                    <p>Des pages qui s’adaptent à tous les écrans, avec une navigation fluide sur mobile, tablette et ordinateur.</p>
                </article>
                <article class="feature-card">
                    <h3>Design cohérent</h3>
                    <p>Une identité visuelle stable, une palette utilisée partout et une typographie simple pour maximiser la lisibilité.</p>
                </article>
                <article class="feature-card">
                    <h3>Code propre</h3>
                    <p>Structure HTML sémantique, CSS bien organisé et respect des bonnes pratiques d’accessibilité.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Projets</span>
                <h2>Mes travaux récents</h2>
            </div>
            <div class="project-preview-grid">
                <article class="project-card">
  <div class="project-copy">
                        <h3>Site responsive</h3>
                        <p>Projet de site vitrine avec une expérience adaptée à tous les écrans et une esthétique soignée.</p>
                        <p class="tech">HTML · CSS · Flexbox · Grid</p>
                    </div>
                </article>
                <article class="project-card">
                    <img src="./javaapp.jpg" alt="Aperçu d'une application JavaScript interactive">
                    <div class="project-copy">
                        <h3>Application JavaScript</h3>
                        <p>Interface interactive en JavaScript avec gestion du DOM et animations légères pour améliorer l’usage.</p>
                        <p class="tech">JavaScript · HTML · CSS</p>
                    </div>
                </article>
                <article class="project-card">
                    <img src="./gestionphp.jpg" alt="Aperçu d'une application PHP de gestion">
                    <div class="project-copy">
                        <h3>Système de gestion PHP</h3>
                        <p>Application CRUD en PHP et MySQL pour gérer des données et afficher des informations en ligne.</p>
                        <p class="tech">PHP · MySQL · HTML · CSS</p>
                    </div>
                </article>
            </div>
            <div class="cta-row">
                <a href="projets.php" class="btn btn-primary">Voir tous les projets</a>
            </div>
        </div>
    </section>
</main>

<?php require 'composants/pied-de-page.php'; ?>
</body>
</html>