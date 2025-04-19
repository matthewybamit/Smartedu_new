<?php
session_start();
session_destroy();
header("Location: landing_logout.php");
exit;
?>
