<?php
require_once '../fonctions.php';

session_destroy();
header('Location: connexion.php');
exit;