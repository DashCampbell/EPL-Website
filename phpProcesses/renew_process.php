<?php

include '../config/sql_functions.php';

session_start();

$renewItemList = $_POST['items'] ?? retrieveAccountItems($_SESSION['currentAccount']);

foreach ($renewItemList as $title)
    renewItem($_SESSION['currentAccount'], $title);


header("Location: ../checkout.php");
