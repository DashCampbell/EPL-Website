<?php
session_start();

if (isset($_GET['key']) && isset($_GET['cFilter'])) {
    // Delete Selected Filters
    array_splice($_SESSION['search-filter'][$_GET['key']], array_search($_GET['cFilter'], $_SESSION['search-filter'][$_GET['key']]), 1);
    // Deletes Array if it is empty
    if (empty($_SESSION['search-filter'][$_GET['key']]))
        unset($_SESSION['search-filter'][$_GET['key']]);
} else {
    $_SESSION['search-filter'] = array();
}
header("Location: ../browse.php");
