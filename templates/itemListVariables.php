<?php
// NOTE: Requires $nTotalItems & $maxItems to be defined

// Page Index, starts at 0
if (isset($_GET['index']))
    $pageIndex = (int)$_GET['index'];
else
    $pageIndex = 0;


$nTotalIndexes = ceil($nTotalItems / $maxItems);

// Current Number of items to be rendered
$nCurrentItems = (($pageIndex + 1) * $maxItems > $nTotalItems) ? $nTotalItems % $maxItems : $maxItems;

// Starts at 0
$nStartIndex = $pageIndex * $maxItems;

// Previous & Next Indexes
$prevIndex = ($pageIndex - 1 + $nTotalIndexes) % ($nTotalIndexes);
$nextIndex = ($pageIndex + 1) % ($nTotalIndexes);
