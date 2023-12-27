<?php

session_start();
if (!isset($_SESSION['bLogin']) || (!$_SESSION['bLogin']))
    header("Location: login.php?prevPage=" . basename($_SERVER['PHP_SELF']));

include 'config/sql_functions.php';

$account = retrieveAccountData($_SESSION['currentAccount']);


$input = $account['Phone Number'];

$errors = array('empty' => '*Field is Empty', 'invalid' => '*Phone Number is Invalid');
$errorMes = '';

$column = 'Phone Number';

// Validate Field
function validate()
{
    return preg_match('/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/', $_POST['column']);
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
            <h1>Account Information: Phone Number</h1>
            <form method="post" class="change-settings-page">
                <div>
                    <h2>Phone Number</h2>
                    <p>
                        Keep your phone number up to date. Your phone number is always private.
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