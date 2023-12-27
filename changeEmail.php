<?php

session_start();
if (!isset($_SESSION['bLogin']) || (!$_SESSION['bLogin']))
    header("Location: login.php?prevPage=" . basename($_SERVER['PHP_SELF']));

include 'config/sql_functions.php';

$account = retrieveAccountData($_SESSION['currentAccount']);


$input = $account['Email'];

$errors = array('empty' => '*Field is Empty', 'invalid' => '*Email is Invalid');
$errorMes = '';

$column = 'Email';

// Validate Field
function validate()
{
    return filter_var($_POST['column'], FILTER_VALIDATE_EMAIL);
}

include 'config/updateAccount.php';

?>

<!doctype html>
<html>

<head>
    <title>Account | Edmonton Public Library</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">
    <link href="Stylesheets/account.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <div class="body-content account-settings">
        <!-- Main Page Content -->
        <?php include 'templates/settingsSideMenu.php'; ?>

        <section>
            <h1>Account Information: Email</h1>
            <form method="post" class="change-settings-page">
                <div>
                    <h2>Email Address</h2>
                    <p>
                        By providing your email address, you consent to receive emails about your library card account and EPL news. You can unsubscribe to EPL’s eNewsletter at any time.
                    </p>
                    <input type="text" name="column" value="<?php echo $input; ?>"><span>*</span>
                    <h6><?php echo $errorMes; ?></h6>
                </div>
                <input type="submit" name="submit" value="Save Changes">
            </form>
        </section>
        <!-- End of Main Content -->
    </div>

    <?php include 'templates/footer.php' ?>

    <!-- Include Javascript Files Here -->
    <script src="scripts/script.js"></script>
</body>

</html>