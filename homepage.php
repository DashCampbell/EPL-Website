<!doctype html>
<html>

<head>
    <title>EPL Homepage</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/homepage_script.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <!-- Main Page Content -->
    <div class="body-content">

        <!-- News Section -->
        <section id="news">
            <h1>News</h1>
            <!-- Gallery Slide Show -->
            <div class="newsGallery-container">
                <ul>
                    <?php foreach (getDirectoryFiles("images/newsGallery") as $panel) : ?>
                        <li>
                            <img src="images/newsGallery/<?php echo $panel; ?>">
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="prev">&#10094;</a>
                <a class="next">&#10095;</a>
            </div>
            <!-- Gallery Selector -->
            <div class="gallery-selector">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </section>
        <!-- Quick Links -->
        <section id="quick-links">
            <h1>Quick Links</h1>
            <ul class="main-page-links">
                <li><a href>Contact EPL</a></li>
                <li><a href='createAccount.php'>Get a Card</a></li>
                <li><a href>EPL From Home</a></li>
                <li><a href>Digital Content</a></li>
                <li><a href>Donate</a></li>
                <li><a href>Hours and Location</a></li>
            </ul>
        </section>
        <!-- Browse -->
        <section id="homepage-browse">
            <h1>Browse</h1>
            <ul class="main-page-links">
                <li><a href='phpProcesses/browse_process.php?format=eBook'>eBooks</a></li>
                <li><a href='phpProcesses/browse_process.php?format=AudioBook'>AudioBooks</a></li>
                <li><a href='phpProcesses/browse_process.php?format=Book'>Books</a></li>
                <li><a href='phpProcesses/browse_process.php?format=Movie'>Movies</a></li>
                <li><a href='phpProcesses/browse_process.php?format=Videogame'>Video Games</a></li>
                <li><a href='phpProcesses/browse_process.php?format=Music'>Music</a></li>
            </ul>
        </section>
        <!-- Digital Content -->
        <section id="homepage-digital">
            <h1>Digital Content</h1>
            <ul class="main-page-links">
                <li><a href='phpProcesses/browse_process.php?format=AudioBook'>AudioBooks</a></li>
                <li><a href='phpProcesses/browse_process.php?format=eBook'>eBooks</a></li>
                <li><a href='phpProcesses/browse_process.php?format=Movie'>Movies and TV</a></li>
                <li><a href='phpProcesses/browse_process.php?format=Music'>Music</a></li>
            </ul>
        </section>
        <!-- End of Main Content -->
    </div>

    <?php include 'templates/footer.php' ?>
</body>

</html>