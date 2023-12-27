<?php
include '../config/sql_functions.php';

session_start();

$titles = $_POST['items'] ?? retrieveAccountItems($_SESSION['currentAccount'], 1);

foreach ($titles as $title)
    cancelHold($_SESSION['currentAccount'], $title);

header("Location: ../holds.php");
