<?php
include '../config/sql_functions.php';

session_start();

// Search Words
$search_terms;

// Search Items
$searchItems = array();

$allItems = retrieveAllItemData();

// Get Search Items
if (isset($_GET['submit']) && $_GET['search'] !== '') {
    // Searched Words
    $search_terms = $_GET['search'];
    $search_terms = strtolower($search_terms);

    // Array of columns to search
    $searchColumns = array();
    switch ($_GET['search-option']) {
            // Search Title Columns
        case 'Title':
            $searchColumns[] = 'Title';
            break;
            // Search Author Columns
        case 'Author':
            $searchColumns[] = 'Author';
            break;
            // Search ALL columns
        default:
            $searchColumns[] = 'Title';
            $searchColumns[] = 'Author';
            $searchColumns[] = 'Subject';
            $searchColumns[] = 'Age';
            $searchColumns[] = 'Subject';
            break;
    }
    // Look in search columns for search terms, then add to searchedItems
    foreach ($allItems as $item) {
        foreach ($searchColumns as $column) {
            $columnVal = retrieveItemValue($column, $item['Title']);
            if (strpos(strtolower($columnVal), $search_terms) !== false) {
                $searchItems[] = $item;
                break;
            }
        }
    }
    $_SESSION['search-filter'] = array();
} else if (isset($_GET['format'])) {
    $search_terms = ($_GET['format'] === 'Music') ? 'Music' : $_GET['format'] . 's';
    $searchItems = $allItems;
    $_SESSION['search-filter'] = array('Format' => array($_GET['format']));
} else if (isset($_GET['age'])) {

    if (count($_GET['age']) > 1)
        $search_terms = 'Children';
    else {
        switch ($_GET['age']) {
            case 'Teen':
            case 'Adult':
                $search_terms = $_GET['age'][0] . 's';
                break;
            default:
                $search_terms = $_GET['age'][0];
        }
    }
    $searchItems = $allItems;
    $_SESSION['search-filter'] = array('Age' => $_GET['age']);
} else if (isset($_GET['subject'])) {
    $search_terms = $_GET['subject'];
    $searchItems = $allItems;
    $_SESSION['search-filter'] = array('Subject' => array($_GET['subject']));
} else {
    // Apply Default Values
    $search_terms = "All Items";
    $searchItems = $allItems;
    $_SESSION['search-filter'] = array();
}

// Save Search Items in Session
// Reset Filters
$_SESSION['searchItems'] = $searchItems;
$_SESSION['search_terms'] = $search_terms;
$_SESSION['search-option'] = $_GET['search-option'];

header("Location: ../browse.php");
