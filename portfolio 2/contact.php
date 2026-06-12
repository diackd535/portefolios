<?php
require 'fonctions.php';
require 'config/connexion.php';
enregistrerVisite($pdo, 'contact');

$contact = [
    'name'    => '',
    'email'   => '',
    'message' => '',
];
$demande = [
    'project-name'   => '',
    'project-type'   => '',
    'project-detail' => '',
];
$contact_errors = [];
$demande_errors = [];
$contact_success = '';
$demande_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? '';

    // ---- FORMULAIRE CONTACT ----
    if ($form_type === 'contact') {

        if (!verifierCSRF($_POST['csrf'] ?? '')) {
            $contact_errors['csrf'] = 'Requête invalide. Veuillez réessayer.';
        } else {

            $contact['name']    = valeur('name', $_POST);
            $contact['email']   = valeur('email', $_POST);
            $contact['message'] = valeur('message', $_POST);

            if (!champ_requis($contact['name']))
                $contact_errors['name'] = 'Le nom est obligatoire.';

            if (!champ_requis($contact['email']))
                $contact_errors['email'] = 'L\'adresse e-mail est obligatoire.';
            elseif (!valider_email($contact['email']))
                $contact_errors['email'] = 'L\'adresse e-mail est invalide.';

            if (!champ_requis($contact['message']))
                $contact_errors['message'] = 'Le message ne peut pas être vide.';

            if (empty($contact_errors)) {
                $stmt = $pdo->prepare('INSERT INTO messages_contact (nom, email, message) VALUES (?, ?, ?)');
                $stmt->execute([
                    trim($_POST['name']),
                    trim($_POST['email']),
                    trim($_POST['message']),
                ]);
                $contact_success = 'Merci ! Votre message a bien été pris en compte.';
                $contact = ['name' => '', 'email' => '', 'message' => ''];
            }
        }
    }

    // ---- FORMULAIRE DEMANDE DE PROJET ----
    if ($form_type === 'project') {

        if (!verifierCSRF($_POST['csrf'] ?? '')) {
            $demande_errors['csrf'] = 'Requête invalide. Veuillez réessayer.';
        } else {

            $demande['project-name']   = valeur('project-name', $_POST);
            $demande['project-type']   = valeur('project-type', $_POST);
            $demande['project-detail'] = valeur('project-detail', $_POST);

            if (!champ_requis($demande['project-name']))
                $demande_errors['project-name'] = 'Le nom du projet est obligatoire.';

            if (!champ_requis($demande['project-type']))
                $demande_errors['project-type'] = 'Le type de projet est obligatoire.';

            if (!champ_requis($demande['project-detail']))
                $demande_errors['project-detail'] = 'La description du projet ne peut pas être vide.';

            if (empty($demande_errors)) {
                $stmt = $pdo->prepare('INSERT INTO demandes_projet (nom, email, type_projet, description) VALUES (?, ?, ?, ?)');
                $stmt->execute([
                    trim($_POST['project-name']),
                    '',
                    trim($_POST['project-type']),
                    trim($_POST['project-detail']),
                ]);
                $demande_success = 'Votre demande de projet a bien été reçue. Je vous recontacterai bientôt.';
                $demande = ['project-name' => '', 'project-type' => '', 'project-detail' => ''];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contactez Djiby pour une demande de projet ou une collaboration en développement web.">
    <title>Contact | Djiby Portfolio</title>
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
                <span class="eyebrow">Contact</span>
                <h1>Parlons de votre prochain projet.</h1>
                <p>Envoyez-moi un message pour toute demande de collaboration, une idée à réaliser ou un besoin technique clair.</p>
            </div>
            <div class="contact-card">
                <p><strong>Mail :</strong> <a href="mailto:tonemail@example.com">tonemail@example.com</a></p>
                <p><strong>GitHub :</strong> <a href="https://github.com/tonpseudo" target="_blank" rel="noreferrer">github.com/tonpseudo</a></p>
                <p><strong>Disponibilité :</strong> ouvert aux projets et aux stages.</p>
            </div>
        </div>
    </section>

    <section class="section section-light">
        <div class="container contact-grid">

            <!-- FORMULAIRE CONTACT -->
            <div class="form-panel">
                <h2>Formulaire de contact</h2>

                <?php if (isset($contact_errors['csrf'])): ?>
                    <div class="form-message form-message--error"><?= nettoyer($contact_errors['csrf']) ?></div>
                <?php endif; ?>

                <?php if ($contact_success): ?>
                    <div class="form-message form-message--success"><?= $contact_success ?></div>
                <?php endif; ?>

                <form method="POST" action="contact.php">
                    <input type="hidden" name="form_type" value="contact">
                    <input type="hidden" name="csrf" value="<?= genererCSRF() ?>">

                    <label for="name">Nom</label>
                    <input id="name" name="name" type="text" placeholder="Votre nom" value="<?= $contact['name'] ?>" required>
                    <?php if (erreur('name', $contact_errors)): ?>
                        <p class="form-error"><?= erreur('name', $contact_errors) ?></p>
                    <?php endif; ?>

                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" placeholder="Votre email" value="<?= $contact['email'] ?>" required>
                    <?php if (erreur('email', $contact_errors)): ?>
                        <p class="form-error"><?= erreur('email', $contact_errors) ?></p>
                    <?php endif; ?>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Votre message" required><?= $contact['message'] ?></textarea>
                    <?php if (erreur('message', $contact_errors)): ?>
                        <p class="form-error"><?= erreur('message', $contact_errors) ?></p>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>

            <!-- FORMULAIRE DEMANDE DE PROJET -->
            <div class="form-panel">
                <h2>Demande de projet</h2>

                <?php if (isset($demande_errors['csrf'])): ?>
                    <div class="form-message form-message--error"><?= nettoyer($demande_errors['csrf']) ?></div>
                <?php endif; ?>

                <?php if ($demande_success): ?>
                    <div class="form-message form-message--success"><?= $demande_success ?></div>
                <?php endif; ?>

                <form method="POST" action="contact.php">
                    <input type="hidden" name="form_type" value="project">
                    <input type="hidden" name="csrf" value="<?= genererCSRF() ?>">

                    <label for="project-name">Nom du projet</label>
                    <input id="project-name" name="project-name" type="text" placeholder="Titre du projet" value="<?= $demande['project-name'] ?>" required>
                    <?php if (erreur('project-name', $demande_errors)): ?>
                        <p class="form-error"><?= erreur('project-name', $demande_errors) ?></p>
                    <?php endif; ?>

                    <label for="project-type">Type de projet</label>
                    <input id="project-type" name="project-type" type="text" placeholder="Site vitrine, application, e-commerce..." value="<?= $demande['project-type'] ?>" required>
                    <?php if (erreur('project-type', $demande_errors)): ?>
                        <p class="form-error"><?= erreur('project-type', $demande_errors) ?></p>
                    <?php endif; ?>

                    <label for="project-detail">Description</label>
                    <textarea id="project-detail" name="project-detail" placeholder="Décrivez votre besoin" required><?= $demande['project-detail'] ?></textarea>
                    <?php if (erreur('project-detail', $demande_errors)): ?>
                        <p class="form-error"><?= erreur('project-detail', $demande_errors) ?></p>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-secondary">Envoyer la demande</button>
                </form>
            </div>

        </div>
    </section>
</main>

<?php require 'composants/pied-de-page.php'; ?>
</body>
</html>