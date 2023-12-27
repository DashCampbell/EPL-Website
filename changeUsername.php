<?php

session_start();
if (!isset($_SESSION['bLogin']) || (!$_SESSION['bLogin']))
    header("Location: login.php?prevPage=" . basename($_SERVER['PHP_SELF']));

include 'config/sql_functions.php';

$account = retrieveAccountData($_SESSION['currentAccount']);


$input = $account['Name'];

$errors = array('empty' => '*Field is Empty', 'invalid' => '*Username is Invalid');
$errorMes = '';

$column = 'Name';

// Validate Field
function validate()
{
    if (preg_match('/^[\w\s!@#$%^&*]{1,24}$/', $_POST['column'])) {
        $_SESSION['currentAccount'] = $_POST['column'];
        return true;
    } else
        return false;
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
            <h1>Account Information: Username</h1>
            <form method="post" class="change-settings-page">
                <div>
                    <h2>Username</h2>
                    <p>
                        Your username is the name that will be displayed publicly next to any comments or summaries that you contribute to the site.
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