<?php
session_start();
if (!isset($_SESSION['bLogin']) || (!$_SESSION['bLogin']))
    header("Location: login.php?prevPage=" . basename($_SERVER['PHP_SELF']));

include 'config/sql_functions.php';

$itemTitles = retrieveAccountItems($_SESSION['currentAccount'], 1);

$itemList = array();
foreach ($itemTitles as $title)
    $itemList[] = retrieveItemData($title);


$nTotalItems = count($itemTitles);
if (!empty($itemList)) {
    // Default Sort Method
    if (!isset($_GET['sort']))
        $_GET['sort'] = 'Title';

    $maxItems = 5;

    include 'templates/itemListVariables.php';
}
?>

<!doctype html>
<html>

<head>
    <title>Holds | EPL Public Library</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">
    <link href="Stylesheets/account.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
    <script src="scripts/script.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <div id="holdsPage" class="body-content">
        <!-- Main Page Content -->

        <!-- Left Side Menu -->
        <?php include 'templates/accountSideMenu.php' ?>

        <!-- Main Checkout Content -->
        <section class="accountItemsPage">
            <h2>Holds</h2>
            <div>
                <!-- Total # of Items -->
                <h2><?php echo $nTotalItems; ?> items</h2>

                <?php if (!empty($itemTitles)) : ?>

                    <?php include 'templates/sortItemsHeader.php'; ?>

                    <div class="accountItemsList">
                        <form action="phpProcesses/cancelHold_process.php" method="post">
                            <!-- Select All Checkbox -->
                            <label class="accountCheckBox">
                                <input type="checkbox" name="allItems" value="all">
                                <span></span>
                                <p>Select All <?php echo $nTotalItems; ?> items</p>
                            </label>
                            <!-- Rendered Items List -->
                            <ul>
                                <?php
                                for ($i = $nStartIndex; $i < ($nCurrentItems + $nStartIndex); $i++) :
                                    $item = $itemList[$i];
                                ?>
                                    <li>
                                        <!-- Check Box -->
                                        <label class="accountCheckBox">
                                            <input type="checkbox" name="items[]" value="<?php echo $item['Title']; ?>">
                                            <span></span>
                                        </label>
                                        <div>
                                            <div class="accountItem-left-description">
                                                <a href><img src="<?php echo $item['Cover_URL']; ?>"></a>
                                                <div>
                                                    <a href><?php echo $item['Title']; ?></a>
                                                    <p>by <a href><?php echo $item['Author']; ?></a></p>
                                                    <!-- Format - Date -->
                                                    <p><?php echo $item['Format'] . ' - ' . date('Y', strtotime($item['Published Date'])); ?></p>
                                                    <a href>View Details</a>
                                                </div>
                                            </div>
                                            <div class="accountItem-right-description holds-description">
                                                <h2><span><span>-</span> Not Ready</span><b>#<?php echo $item['Holds']; ?></b> on <?php echo $item['Copies']; ?> copies</h2>
                                                <input type="submit" value="Cancel Hold">
                                            </div>
                                        </div>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Index Footer -->
            <?php if (!empty($itemTitles)) include 'templates/sortItemsFooter.php'; ?>
        </section>
        <!-- Cancel All Items Slide Up Menu-->
        <div class="account-footer-menu">
            <span><?php echo count($itemTitles) . ' selected'; ?></span><button>Clear</button>
            <a href="phpProcesses/cancelHold_process.php">Cancel All Holds (<?php echo count($itemTitles) . ')'; ?></a>
        </div>
    </div>
    <!-- End of Main Content -->
    <?php include 'templates/footer.php' ?>

    <script src="scripts/account_script.js"></script>
</body>

</html>