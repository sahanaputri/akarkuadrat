<?php
session_start();
unset($_SESSION['nim']);
session_destroy();
header('location:index.php');
?>