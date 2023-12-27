<?php
session_start();

$_SESSION['bLogin'] = false;
unset($_SESSION['currentAccount']);

header("Location: ../homepage.php");
