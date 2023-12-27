<?php
session_start();
if (!isset($_SESSION['bLogin']) || (!$_SESSION['bLogin']))
    header("Location: login.php?prevPage=" . basename($_SERVER['PHP_SELF']));

include 'config/sql_functions.php';
$itemTitles = retrieveAccountItems($_SESSION['currentAccount']);
$dates = retrieveCheckoutDates($_SESSION['currentAccount']);

$itemList = array();
// Get Checkout Items & item due dates
foreach ($itemTitles as $i => $title)
    $itemList[] = array('item' => retrieveItemData($title), 'dueDate' => strtotime($dates[$i]));

// Sort Items and define index variables
if (!empty($itemTitles)) {
    // Default Sort Method
    if (!isset($_GET['sort']))
        $_GET['sort'] = 'Due Date';

    // Sort Items
    usort($itemList, function ($a, $b) {
        if ($_GET['sort'] == 'Due Date')
            return $a['dueDate'] - $b['dueDate'];
        else
            return strcmp($a['item'][$_GET['sort']], $b['item'][$_GET['sort']]);
    });

    $nTotalItems = count($itemTitles);
    $maxItems = 5;
    include 'templates/itemListVariables.php';
}
?>

<!doctype html>
<html>

<head>
    <title>Checked Out | EPL Public Library</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">
    <link href="Stylesheets/account.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
    <script src="scripts/script.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <!-- Main Page Content -->
    <div id="checkoutPage" class="body-content">

        <!-- Left Side Menu -->
        <?php include 'templates/accountSideMenu.php' ?>

        <!-- Main Checkout Content -->
        <section class="accountItemsPage">
            <h2>Checked Out</h2>
            <!-- Check Items List -->
            <div>
                <!-- Total number of items -->
                <h2><?php echo count($itemTitles); ?> due later</h2>


                <!-- Check if There are More than zero items -->
                <?php if (!empty($itemTitles)) : ?>
                    <!-- Sort Items Header-->
                    <?php include 'templates/sortItemsHeader.php'; ?>

                    <div class="accountItemsList">

                        <form action="phpProcesses/renew_process.php" method="post">
                            <!-- Select All Checkbox -->
                            <label class="accountCheckBox">
                                <input type="checkbox" name="allItems" value="all">
                                <span></span>
                                <p>Select All <?php echo count($itemTitles); ?> items</p>
                            </label>

                            <!-- Rendered Items List -->
                            <ul>
                                <?php
                                for ($i = $nStartIndex; $i < ($nCurrentItems + $nStartIndex); $i++) :
                                    $item = $itemList[$i]['item'];
                                    $dueDate = $itemList[$i]['dueDate'];
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
                                                </div>
                                            </div>
                                            <div class="accountItem-right-description">
                                                <p><span>Due Later</span> <?php echo floor(($dueDate - time()) / 86400); ?> days remaining</p>
                                                <h2>Due by <?php echo date('M\. d\, Y', $dueDate); ?></h2>
                                                <!-- Renew Button -->
                                                <input type="submit" value="Renew"></input>
                                            </div>
                                        </div>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </form>
                    </div>
                <?php endif; ?>
            </div>


            <?php if (!empty($itemTitles)) include 'templates/sortItemsFooter.php'; ?>

        </section>
        <!-- Renew All Items Slide Up Menu-->
        <div class="account-footer-menu">
            <span><?php echo count($itemTitles) . ' selected'; ?></span><button>Clear</button>
            <a href="phpProcesses/renew_process.php">Renew selected (<?php echo count($itemTitles) . ')'; ?></a>
        </div>
    </div>
    <!-- End of Main Content -->
    <script src="scripts/account_script.js"></script>

    <?php include 'templates/footer.php' ?>

</body>

</html>