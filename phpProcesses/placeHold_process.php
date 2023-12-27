<?php
if (isset($_GET['item'])) {
    session_start();

    // Redirect to login page if not logged in
    if (!$_SESSION['bLogin']) {
        header("Location: ../login.php");
    } else {
        include '../config/sql_functions.php';

        // Check if Account Already has holds on item
        $accountItems = array_merge(
            retrieveAccountItems($_SESSION['currentAccount'], 0),
            retrieveAccountItems($_SESSION['currentAccount'], 1)
        );
        if (!in_array($_GET['item'], $accountItems)) {
            if (isset($_GET['errorMes']))
                unset($_GET['errorMes']);

            // Check out item
            checkOutItem($_SESSION['currentAccount'], $_GET['item']);

            // Update Searched Item
            $allItems = retrieveAllItemData();
            if (count($_SESSION['searchItems']) === count($allItems)) {
                $_SESSION['searchItems'] = $allItems;
            } else {
                foreach ($_SESSION['searchItems'] as &$item) {
                    $item = retrieveItemData($item['Title']);
                }
            }
        } else {
            // Redirect to Previous Page with error message
            $_GET['errorMes']  = $_GET['item'];
        }
        header("Location: ../browse.php?" . http_build_query($_GET));
        exit;
    }
}
