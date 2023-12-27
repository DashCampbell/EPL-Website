<?php
include 'config/sql_functions.php';

session_start();

// Calls browse_process.php if search button was not pressed
if (!isset($_SESSION['searchItems']))
    header("Location: phpProcesses/browse_process.php");

$searchItems = $_SESSION['searchItems'];
$search_terms = $_SESSION['search_terms'];
$_GET['search-option'] = $_SESSION['search-option'];

// Filter Search Results
$filteredItems = array();

if (!empty($_SESSION['search-filter'])) {
    // iterate through all items
    foreach ($searchItems as $item) {
        $bFilter = false;
        // Iterate through each column

        foreach ($_SESSION['search-filter'] as $key => $filters) {
            $bFilter = false;
            // Iterate through filters of filter type
            foreach ($filters as $filter) {
                if ($filter === $item[$key]) {
                    $bFilter = true;
                    break;
                }
            }
            if (!$bFilter)
                break;
        }
        if ($bFilter)
            $filteredItems[] = $item;
    }
} else {
    // If no filters applied, then filterItems = searched items
    $filteredItems = $searchItems;
}

// Check if there were any filtered search results
if (!empty($filteredItems)) {
    // Sort Items
    if (!isset($_GET['sort'])) {
        // Default Sort Method
        $_GET['sort'] = 'Title';
    }
    usort($filteredItems, function ($itemA, $itemB) {
        return strcmp($itemA[$_GET['sort']], $itemB[$_GET['sort']]);
    });


    // Total Number of Searched Items
    $nTotalItems = count($filteredItems);
    // Max Items to be Rendered
    $maxItems = 10;
    include 'templates/itemListVariables.php';
}
?>

<!doctype html>
<html>

<head>
    <title>Search | Edmonton Public Library</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/browse_script.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <div id="browse-page" class="body-content">
        <div>
            <h2>Keyword search: </h2>
            <span><?php echo htmlspecialchars($search_terms); ?></span>
        </div>
        <!-- Main Page Content -->
        <?php if (!empty($filteredItems)) : ?>
            <div>
                <!-- Filter Area -->
                <section class="browse-filter">
                    <h1>Filter your results by...</h1>
                    <form action="phpProcesses/filter_process.php" method="post">
                        <?php
                        // Check if box was previously checked
                        function bCheckBox($box)
                        {
                            foreach ($_SESSION['search-filter'] as $filters) {
                                if (in_array($box, $filters)) {
                                    echo "checked";
                                    break;
                                }
                            }
                        }
                        function nGetFilterItems($filterType, $filter)
                        {
                            global $searchItems;
                            $nItems = 0;
                            foreach ($searchItems as $item) {
                                if ($item[$filterType] === $filter) {
                                    $nItems++;
                                }
                            }
                            return $nItems;
                        }
                        // Get List of Filters
                        $filters = array();
                        $filters[] = ['Filter' => "Format", 'Checkboxes' => retrieveColumnEnum('Format', 'epl_item')];
                        $filters[] = ['Filter' => "Content", 'Checkboxes' => retrieveColumnEnum('Content', 'epl_item')];
                        $filters[] = ['Filter' => "Subject", 'Checkboxes' => retrieveColumnEnum('Subject', 'epl_item')];
                        $filters[] = ['Filter' => "Age", 'Checkboxes' => retrieveColumnEnum('Age', 'epl_item')];
                        ?>
                        <!-- Filter Button -->
                        <input type="submit" name="filter-submit" value="Filter Results">
                        <!-- Make List of all the filters -->
                        <?php
                        $i = -1;
                        foreach ($filters as $filter) :
                            $i++
                        ?>
                            <h2><?php echo $filter['Filter']; ?> <span>&#x142F;</span></h2>
                            <!-- Only Show First or Active Filter Lists -->
                            <ul <?php if ($i < 2 || (!empty($_SESSION['search-filter'][$filter['Filter']]))) echo 'style="display: block;"'; ?>>
                                <?php foreach ($filter['Checkboxes'] as $filterBox) : ?>
                                    <li>
                                        <label class="filter-label">
                                            <input class="filter-input" type="checkbox" name="search-filter[<?php echo $filter['Filter']; ?>][]" value="<?php echo $filterBox; ?>" <?php bCheckBox($filterBox); ?>>
                                            <span></span>
                                            <?php echo $filterBox . ' (' . nGetFilterItems($filter['Filter'], $filterBox) . ')'; ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    </form>
                </section>
                <!-- Searched Items Area -->
                <section class="browse-items-section">
                    <div>
                        <!-- Clear Filters Header -->
                        <?php if (count($_SESSION['search-filter']) > 0) : ?>
                            <div class="browse-items-filters">
                                <ul>
                                    <?php
                                    foreach ($_SESSION['search-filter'] as $key => $filters) :
                                        foreach ($filters as $filter) :
                                    ?>
                                            <li>
                                                <a href="phpProcesses/filter_clear.php?key=<?php echo $key; ?>&cFilter=<?php echo $filter ?>"><span><?php echo $filter; ?></span> X</a>
                                            </li>
                                    <?php endforeach;
                                    endforeach;
                                    ?>
                                    <li><a href="phpProcesses/filter_clear.php">Clear Filters</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Sort Items Header-->
                        <?php include 'templates/sortItemsHeader.php'; ?>

                        <!-- Render Searched Items -->
                        <div class="browse-items">
                            <?php
                            for ($i = $nStartIndex; $i < $nCurrentItems + $nStartIndex; $i++) :
                                $item = $filteredItems[$i];
                            ?>
                                <div class="browse-item">
                                    <!-- Link to More Information on Item & Cover Image-->
                                    <a href><img src="<?php echo $item['Cover_URL']; ?>" alt="<?php echo $item['Title']; ?>"></a>
                                    <!-- Item Info -->
                                    <div>
                                        <div class="item-description-top">
                                            <!-- Mobile Image Cover-->
                                            <a class="mobile-img-cover" href><img src="<?php echo $item['Cover_URL']; ?>" alt="<?php echo $item['Title']; ?>"></a>
                                            <div>
                                                <!-- Link to More Information on Item -->
                                                <a href><?php echo $item['Title']; ?></a>
                                                <!-- Link to Author's Work -->
                                                <h3>by <a href><?php echo $item['Author']; ?></a></h3>
                                            </div>
                                        </div>
                                        <div class="item-description-bottom">
                                            <?php if (isset($_GET['errorMes']) && $_GET['errorMes'] === $item['Title']) : ?>
                                                <p>User already has this title charged out</p>
                                            <?php endif; ?>
                                            <div>
                                                <!-- Format & Date & Link to More Info. -->
                                                <a href><?php echo $item['Format'] . ' - ' . date('Y', strtotime($item['Published Date'])); ?></a>

                                                <!-- Check if All Copies in use -->
                                                <?php if ($item['Holds'] >= $item['Copies']) : ?>
                                                    <h3>All copies in use <a href>View details</a></h3>
                                                <?php else : ?>
                                                    <h2>Available</h2>
                                                <?php endif; ?>
                                                <p>Holds: <?php echo $item['Holds']; ?> on <?php echo $item['Copies'] . ' ' . ($item['Copies'] > 1 ? 'copies' : 'copy'); ?></p>
                                            </div>
                                            <!-- Place a Hold Button -->
                                            <a href="phpProcesses/placeHold_process.php?
                                        <?php $_GET['item'] = $item['Title'];
                                        echo http_build_query($_GET); ?>">
                                                Place a Hold
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <!-- Sort Items Footer-->
                    <?php include 'templates/sortItemsFooter.php'; ?>

                </section>
            </div>
        <?php else : ?>
            <div style="border: none;">
                <h2>No search results. Please Try Again.</h2>
            </div>
        <?php endif; ?>
        <!-- End of Main Content -->
    </div>

    <?php include 'templates/footer.php' ?>
</body>

</html>