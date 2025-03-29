<?php
// Start the session
session_start();

// Include necessary files
require_once("src/Config.php");
require_once("src/Database.php");
require_once("src/ArtChallengeController.php");

// Create a new controller instance, passing $_GET as input
$controller = new ArtChallengeController($_GET);

// Run the application
$controller->run();
?>