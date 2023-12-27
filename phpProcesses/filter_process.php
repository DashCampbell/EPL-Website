<?php

session_start();
// If New Filters Applied, apply filters in session
$_SESSION['search-filter'] = isset($_POST['search-filter']) ? $_POST['search-filter'] : array();

header("Location: ../browse.php");
