<?php
session_start();
if (!isset($_SESSION['bLogin']) || (!$_SESSION['bLogin']))
    header("Location: login.php?prevPage=" . basename($_SERVER['PHP_SELF']));

include 'config/sql_functions.php';

$account = retrieveAccountData($_SESSION['currentAccount']);


?>

<!doctype html>
<html>

<head>
    <title>Account | Edmonton Public Library</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">
    <link href="Stylesheets/account.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
    <script src="scripts/script.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <div class="body-content account-settings">
        <!-- Main Page Content -->
        <?php include 'templates/settingsSideMenu.php'; ?>

        <section class="settings-page">
            <h1>My Settings</h1>
            <div>
                <div>
                    <span><?php echo $account['Name'][0]; ?></span>
                    <div>
                        <a href><?php echo $account['Name']; ?></a>
                        <p>Edmonton Public Library</p>
                    </div>
                </div>
                <p><b>Barcode: </b><?php echo $account['username']; ?></p>
                <p><b>Name: </b><?php echo $account['Full Name']; ?></p>
                <p><b>Date of Birth: </b>09/18/20</p>
            </div>
            <h2>Account Information</h2>
            <ul>
                <li>
                    <h4>Email Address</h4>
                    <p>Update your email address. <a href='changeEmail.php'>Change</a></p>
                </li>
                <li>
                    <h4>Username</h4>
                    <p>Manage your username and the name that displays in the catalogue. <a href='changeUsername.php'>Change</a></p>
                </li>
                <li>
                    <h4>Password</h4>
                    <p>Change your account password. <a href='changePassword.php'>Change</a></p>
                </li>
                <li>
                    <h4>Phone Number</h4>
                    <p>Keep your phone number up to date. Your phone number is always private. <a href='changePhoneNum.php'>Change</a></p>
                </li>
            </ul>

        </section>
        <!-- End of Main Content -->
    </div>

    <?php include 'templates/footer.php' ?>
</body>

</html>