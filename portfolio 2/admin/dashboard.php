<?php
require_once '../fonctions.php';
require_once '../config/connexion.php';

// Protection : si pas connecté → rediriger
if (!isset($_SESSION['admin_id'])) {
    header('Location: connexion.php');
    exit;
}

// Nombre total de projets
$stmt = $pdo->query('SELECT COUNT(*) FROM projets');
$nb_projets = $stmt->fetchColumn();

// Nombre de messages non lus
$stmt = $pdo->query('SELECT COUNT(*) FROM messages_contact WHERE lu = 0');
$nb_messages = $stmt->fetchColumn();

// Nombre de demandes non lues
$stmt = $pdo->query('SELECT COUNT(*) FROM demandes_projet WHERE lu = 0');
$nb_demandes = $stmt->fetchColumn();

// 5 dernières visites
$stmt = $pdo->query('SELECT adresse_ip, page, date_visite FROM visites ORDER BY date_visite DESC LIMIT 5');
$dernieres_visites = $stmt->fetchAll();

// 5 dernières demandes de projet
$stmt = $pdo->query('SELECT nom, type_projet, date_demande FROM demandes_projet ORDER BY date_demande DESC LIMIT 5');
$dernieres_demandes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<nav>
    <span>Bonjour, <?= nettoyer($_SESSION['admin_prenom']) ?> 👋</span>
    <a href="projets/index.php">Projets</a>
    <a href="utilisateurs/index.php">Administrateurs</a>
    <a href="messages/index.php">Messages</a>
    <a href="demandes/index.php">Demandes</a>
    <a href="deconnexion.php">Se déconnecter</a>
</nav>

<main>
    <h1>Dashboard</h1