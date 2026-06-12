<?php
require 'fonctions.php';
require 'config/connexion.php';
enregistrerVisite($pdo, 'about');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="À propos de Djiby - développeur web passionné, compétent en front-end et back-end.">
    <title>À propos | Djiby Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php require 'composants/navigation.php'; ?>

<main>
    <section class="section section-intro">
        <div class="container split-grid">
            <div>
                <span class="eyebrow">À propos de moi</span>
                <h1>Je conçois des expériences web claires, accessibles et performantes.</h1>
                <p>Je suis Djiby, développeur web motivé par l’optimisation et le design réfléchi. J’aime transformer une idée en site structuré, agréable et facile à utiliser.</p>
            </div>
            <div class="about-card">
                <h2>Ce que j’apporte</h2>
                <ul>
                    <li>Conception responsive pour tous les écrans</li>
                    <li>Code structuré et maintenable</li>
                    <li>Performance et accessibilité</li>
                    <li>Collaboration claire et professionnelle</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section section-light">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Compétences</span>
                <h2>Ma stack technique</h2>
            </div>
            <div class="skills-grid">
                <article class="skill-card">
                    <h3>HTML</h3>
                    <p>Structure sémantique, balises accessibles, référencement naturel.</p>
                </article>
                <article class="skill-card">
                    <h3>CSS</h3>
                    <p>Responsive, Flexbox, Grid, animations fluides et cohérentes.</p>
                </article>
                <article class="skill-card">
                    <h3>JavaScript</h3>
                    <p>Interactivité, DOM, gestion d’événements et comportements dynamiques.</p>
                </article>
                <article class="skill-card">
                    <h3>PHP & MySQL</h3>
                    <p>Back-end simple, formulaires sécurisés et gestion de données.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Parcours</span>
                <h2>Mon évolution</h2>
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <strong>2022</strong>
                    <p>Découverte du web avec HTML et CSS. Premières pages statiques créées avec soin.</p>
                </div>
                <div class="timeline-item">
                    <strong>2023</strong>
                    <p>Apprentissage de JavaScript et création d’interfaces interactives pour des projets scolaires.</p>
                </div>
                <div class="timeline-item">
                    <strong>2024</strong>
                    <p>Renforcement du back-end avec PHP et MySQL, conception de systèmes de gestion de données.</p>
                </div>
                <div class="timeline-item">
                    <strong>2026</strong>
                    <p>Portfolio en ligne avec un focus sur la qualité, la cohérence visuelle et l’expérience utilisateur.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-quote">
        <div class="container quote-card">
            <h2>Pourquoi travailler avec moi ?</h2>
            <p>Parce que je mets en place des sites clairs, durables et faciles à maintenir, en privilégiant toujours l’utilisateur final.</p>
        </div>
    </section>
</main>

<?php require 'composants/pied-de-page.php'; ?>
</body>
</html>