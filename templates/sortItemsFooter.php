<!-- Sort Items Footer-->
<div class="browse-order-footer">
    <!-- Searched Items Index (i.e. Items 1-25) -->
    <span>
        <?php echo $nStartIndex + 1; ?> to <?php echo ($nStartIndex + $nCurrentItems) . ' of ' . $nTotalItems . ' results'; ?>
    </span>
    <nav>
        <a class="browse-index-prev" href="<?php echo change_URL_VAR('index', $prevIndex); ?>">&#10094;</a>

        <!-- Add Page indexes -->
        <?php for ($i = 0; $i < $nTotalIndexes; $i++) : ?>
            <a class="browse-index-pages" href="<?php echo change_URL_VAR('index', $i); ?>" style="<?php if ($i == $pageIndex) echo 'background: #02729e; color: #fff;' ?>"><?php echo $i + 1 ?></a>
        <?php endfor; ?>

        <a class=" browse-index-next" href="<?php echo change_URL_VAR('index', $nextIndex); ?>">&#10095;</a>
    </nav>
</div>