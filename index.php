<?php
session_start();

ob_start();
require_once __DIR__ . '/database/runBuilder.php';
ob_end_clean();

header("Location: pages/homePage.php");
exit();
?>