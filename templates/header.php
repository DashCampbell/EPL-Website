<?php

if (!isset($_SESSION))
    session_start();
if (!isset($_SESSION['bLogin']))
    $_SESSION['bLogin'] = false;

// Functions
function getDirectoryFiles($directory)
{
    //    File Names
    $fileNames = array();

    if (is_dir($directory)) {
        if ($handler = opendir($directory)) {
            while (($file = readdir($handler)) != false) {
                array_push($fileNames, $file);
            }
            closedir($handler);
        }
    }
    array_splice($fileNames, 0, 2);
    return $fileNames;
}
/**Produces a url with one changed GET variable*/
function change_URL_VAR($get_var, $get_val)
{
    $query = $_GET;
    $query[$get_var] = $get_val;
    $query_result = http_build_query($query);

    echo $_SERVER['PHP_SELF'] . '?' . $query_result;
}
?>

<header>
    <div class="wrapper">
        <div class="top-header">
            <nav>
                <ul>
                    <li id="login-btn">
                        <div><span><?php echo ($_SESSION['bLogin']) ? $_SESSION['currentAccount'] : 'Log In / My EPL'; ?></span> &#x142F;</div>
                        <ul>
                            <li>
                                <a href=<?php echo $_SESSION['bLogin'] ? 'phpProcesses/logout_process.php' : 'login.php'; ?>>
                                    <?php echo $_SESSION['bLogin'] ? 'Log Out' : 'Log In / Register'; ?>
                                </a>
                            </li>
                            <li>
                                <h1>My Borrowing</h1>
                            </li>
                            <li><a href="checkout.php">Checked Out</a></li>
                            <li><a href="holds.php">On Hold</a></li>
                            <li><a href='borrowedItems.php'>Borrowing History</a></li>
                            <li><a href='fees.php'>Fees</a></li>
                            <li><a href>My Profile</a></li>
                            <li><a href='accountSettings.php'>My Settings</a></li>
                        </ul>
                    </li>
                    <li id="help-btn">
                        <a href>
                            <span>Help</span>
                            <span>&#x2370;</span>
                            &#x142F;
                        </a>
                    </li>
                    <li id="hours-btn"><a href><span>Hours & Locations</span> <img src="images/location_icon.jpg">&#x142F;</a></li>
                </ul>
            </nav>
        </div>
        <div id="middle-header">
            <a href="homepage.php" class="header-logo">
                <img src="//cor-liv-cdn-static.bibliocommons.com/images/CAN-EPL/logo.png?1595750823034" alt="EPL-Logo">
            </a>
            <!-- Mobile Button -->
            <div id="mobile-search-btn">
                Search &#x142F;
            </div>

            <div id="header-search">
                <form action="phpProcesses/browse_process.php" method="GET">
                    <span>Search by</span>
                    <select name="search-option">
                        <?php
                        // Check if search option was selected
                        function selectedSearchOption($option)
                        {
                            if (isset($_GET['search-option']) && $_GET['search-option'] == $option) {
                                echo "selected='true'";
                            }
                        }
                        ?>
                        <option <?php selectedSearchOption('Keyword'); ?>>Keyword</option>
                        <option <?php selectedSearchOption('Title'); ?>>Title</option>
                        <option <?php selectedSearchOption('Author'); ?>>Author</option>
                    </select>
                    <div id="search-bar">
                        <input text="" name="search">
                        <button type="submit" name="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="bottom-header">
            <!-- Mobile Button -->
            <span id="mobile-nav-btn">Menu &#x142F;</span>
            <!-- Menu Navigation -->
            <ul>
                <li>
                    <p>Browse &#x142F;</p>
                </li>
                <li>
                    <p>What's On &#x142F;</p>
                </li>
                <li>
                    <p>Digital Content &#x142F;</p>
                </li>
                <li>
                    <p>Services &#x142F;</p>
                </li>
            </ul>
            <!-- Browser Menu -->
            <div class="bottom-drop-menu">
                <h1>Browse</h1>
                <ul>
                    <li>
                        <h2>Format</h2>
                    </li>
                    <li><a href="phpProcesses/browse_process.php?format=Book">Books</a></li>
                    <li><a href="phpProcesses/browse_process.php?format=Movie">Movies</a></li>
                    <li><a href="phpProcesses/browse_process.php?format=Videogame">Videogames</a></li>
                    <li><a href="phpProcesses/browse_process.php?format=Music">Music</a></li>
                </ul>
                <ul>
                    <li>
                        <h2>Explore</h2>
                    </li>
                    <li><a href>Award Winners</a></li>
                    <li><a href>Best Sellers</a></li>
                </ul>
            </div>
            <!-- What's On Menu -->
            <div class="bottom-drop-menu">
                <h1>What's On</h1>
                <ul>
                    <li>
                        <h2>Audience</h2>
                    </li>
                    <li><a href="phpProcesses/browse_process.php?age[]=Kids 1-6&age[]=Kids 6-12">Children</a></li>
                    <li><a href="phpProcesses/browse_process.php?age[]=Teen">Teens</a></li>
                    <li><a href="phpProcesses/browse_process.php?age[]=Adult">Adults</a></li>
                </ul>
            </div>
            <!-- Digital Content Menu -->
            <div class="bottom-drop-menu">
                <h1>Digital Content</h1>
                <ul>
                    <li>
                        <h2>View</h2>
                    </li>
                    <li><a href>Epl From Home</a></li>
                    <li><a href>Getting Started Guide</a></li>
                    <li><a href>All Online Resources</a></li>
                </ul>
                <ul>
                    <li>
                        <h2>Subject</h2>
                    </li>
                    <li><a href="phpProcesses/browse_process.php?subject=<?php echo urlencode('Art & Literature'); ?>">Art & Literature</a></li>
                    <li><a href="phpProcesses/browse_process.php?subject=Finance">Finance</a></li>
                    <li><a href="phpProcesses/browse_process.php?subject=Research">Research</a></li>
                    <li><a href="phpProcesses/browse_process.php?subject=Biography">Biographies</a></li>
                </ul>
                <ul>
                    <li>
                        <h2>Activity</h2>
                    </li>
                    <li><a href>Learn</a></li>
                    <li><a href>Listen</a></li>
                    <li><a href>Read</a></li>
                    <li><a href>Research</a></li>
                </ul>
            </div>
            <!-- Services Menu -->
            <div class="bottom-drop-menu">
                <h1>Services</h1>
                <ul>
                    <li>
                        <h2>Resources For</h2>
                    </li>
                    <li><a href="phpProcesses/browse_process.php?age[]=Adult">Adults</a></li>
                    <li><a href="phpProcesses/browse_process.php?age[]=Teen">Teens</a></li>
                    <li><a href="phpProcesses/browse_process.php?age[]=Kids 6-12">Kids 6-12</a></li>
                    <li><a href="phpProcesses/browse_process.php?age[]=Kids 1-6">Kids 1-6</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>