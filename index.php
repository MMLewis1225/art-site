<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once("src/Config.php");
require_once("src/Database.php");
require_once("src/ArtChallengeController.php");

$controller = new ArtChallengeController($_GET);

$controller->run();
?>