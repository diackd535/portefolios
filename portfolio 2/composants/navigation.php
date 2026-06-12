<?php
$page_courante = basename($_SERVER['PHP_SELF']);
$liens_nav = [
    'index.php'   => 'Accueil',
    'about.php'   => 'À propos',
    'projets.php' => 'Projets',
    'contact.php' => 'Contact',
];
?>
<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="brand">
            <span class="brand-mark">D</span>
            <span class="brand-text">Djiby Portfolio</span>
        </a>
        <nav aria-label="Navigation principale">
            <ul class="nav-list">
                <?php foreach ($liens_nav as $url => $label) : ?>
                    <li>
                        <a href="<?= $url ?>"<?php if ($page_courante === $url) echo ' class="actif"'; ?>>
                            <?= $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>
