<?php
session_start();

$_SESSION = [];
session_destroy();

header("Location: Front/index.php");
exit;
?>