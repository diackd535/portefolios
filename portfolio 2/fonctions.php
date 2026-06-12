<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

/* Validation */

function nettoyer(string $valeur): string {
    return htmlspecialchars(trim($valeur), ENT_QUOTES, 'UTF-8');
}

function champ_requis(string $valeur): bool {
    return trim($valeur) !== '';
}

function valider_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function valeur(string $nom, array $source, string $defaut = ''): string {
    return nettoyer($source[$nom] ?? $defaut);
}

function erreur(string $champ, array $erreurs): string {
    return $erreurs[$champ] ?? '';
}

/* CSRF */

function genererCSRF(): string {

    if(empty($_SESSION['csrf'])){

        $_SESSION['csrf'] =
        bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

function verifierCSRF(string $token): bool {

    return isset($_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $token);
}

/* Journalisation */

function enregistrerVisite(PDO $pdo, string $page): void {

    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $sql = "INSERT INTO visites(adresse_ip, page)
            VALUES (?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ip, $page]);
}