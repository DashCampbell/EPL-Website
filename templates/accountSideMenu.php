<?php
$nCheckoutItems = count(retrieveAccountItems($_SESSION['currentAccount']));
$nHoldItems = count(retrieveAccountItems($_SESSION['currentAccount'], 1));

?>

<!-- Account Side Menu -->
<section id="accountMenuNav">
    <div>
        <h2>My Borrowing</h2>
        <h3>at <span>Edmonton Public Library</span></h3>
    </div>
    <nav>
        <?php
        $fileName = explode('.', basename($_SERVER['PHP_SELF']))[0];
        function currentPage($page)
        {
            global $fileName;
            if (strcmp($fileName, $page) === 0)
                echo 'class="currentAccountLink"';
        }
        ?>
        <ul>
            <li>
                <a href="holds.php" <?php currentPage('holds'); ?>>
                    On Hold<span><?php echo $nHoldItems; ?> ></span><br>
                    <p><span>&#x2714;</span>1</p>
                </a>
            </li>
            <li>
                <a href="checkout.php" <?php currentPage('checkout'); ?>>
                    Checked Out<span><?php echo $nCheckoutItems; ?> ></span><br>
                    <?php
                    function getFirstDueDate()
                    {
                        // Get Item Due Dates
                        $dates = retrieveCheckoutDates($_SESSION['currentAccount']);
                        if (!empty($dates)) {
                            foreach ($dates as &$date) {
                                $date = strtotime($date);
                            }
                            usort($dates, function ($dateA, $dateB) {
                                return $dateA - $dateB;
                            });

                            return date('M\. d', $dates[0]);
                        }
                    }

                    if (strcmp($fileName, 'checkout') === 0) :
                    ?>
                        <div>
                            <h2>Due Later</h2>
                            <h4>Next due on <?php echo getFirstDueDate(); ?></h4>
                        </div>
                    <?php else : ?>
                        <p><?php echo getFirstDueDate(); ?></p>
                    <?php endif; ?>
                </a>
            </li>
            <li><a href="borrowedItems.php" <?php currentPage('borrowedItems'); ?>>Borrowing History<span>></span></a></li>
            <li><a href="fees.php" <?php currentPage('fees'); ?>>Fees<span>$0.00 ></span></a></li>
        </ul>
    </nav>
</section>