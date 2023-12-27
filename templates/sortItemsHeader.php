<!-- Sort Items Header-->
<div class="browse-items-order">
    <span>Sort By:</span>
    <!-- Sort Methods List -->
    <div>
        <!-- Current Sort Method -->
        <span>
            <p><?php echo $_GET['sort']; ?></p> &#x142F;
        </span>
        <!-- Sort Method Drop Menu -->
        <ul>
            <?php
            $sortMethods = array("Title", "Author", "Published Date", "Age");
            if (basename($_SERVER['PHP_SELF']) === 'checkout.php')
                array_unshift($sortMethods, 'Due Date');

            foreach ($sortMethods as $sortMethod) : ?>
                <li>
                    <a href="<?php echo change_URL_VAR('sort', $sortMethod); ?>" style="<?php if ($_GET['sort'] === $sortMethod) echo 'color: #333'; ?>">
                        <?php echo $sortMethod; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- Elements Float Right -->
    <!-- Searched Items Index (i.e. Items 1-25) -->
    <nav>
        <a class="browse-index-prev" href="<?php echo change_URL_VAR('index', $prevIndex); ?>">&#10094;</a>
        <a class="browse-index-next" href="<?php echo change_URL_VAR('index', $nextIndex); ?>">&#10095;</a>
    </nav>
    <span>
        <?php echo $nStartIndex + 1; ?> to <?php echo ($nStartIndex + $nCurrentItems) . ' of ' . $nTotalItems . ' results'; ?>
    </span>
</div>