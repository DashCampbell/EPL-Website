<?php

session_start();
if (!isset($_SESSION['bLogin']) || (!$_SESSION['bLogin']))
    header("Location: login.php?prevPage=" . basename($_SERVER['PHP_SELF']));

include 'config/sql_functions.php';

$account = retrieveAccountData($_SESSION['currentAccount']);


$passwords = array('currentPassword' => '', 'newPassword' => '', 'confirmPassword' => '');

$errors = array('empty' => '*Field is Empty', 'invalid' => '*Password is Invalid');
$errorMes = array('currentPassword' => '', 'newPassword' => '', 'confirmPassword' => '');

$column = 'password';

if (isset($_POST['submit'])) {
    $passwords = $_POST['passwords'];

    foreach ($passwords as $key => $password) {
        // Validate Password Format
        if (empty($password)) {
            $errorMes[$key] = $errors['empty'];
        } else {
            if (!preg_match('/^[\w(!@#$%\^&*())(<>?\/\\)]{4,6}$/', $password)) {
                $errorMes[$key] = $errors['invalid'];
            }
        }
    }
    $currentPassword = $passwords['currentPassword'];
    $newPassword = $passwords['newPassword'];
    $confirmPassword = $passwords['confirmPassword'];

    // Check if there are no error messages
    $bNoErrors = false;
    foreach ($errorMes as $error) {
        if (!empty($error)) {
            $bNoErrors = true;
            break;
        }
    }
    // Confirm Passwords
    if (!$bNoErrors) {
        if ($currentPassword !== $account['password']) {
            $errorMes['currentPassword'] = 'Password is Incorrect';
        } else {
            if ($newPassword !== $confirmPassword) {
                $errorMes['newPassword'] = 'New Password does not match Confirmed Password';
                $errorMes['confirmPassword'] = 'New Password does not match Confirmed Password';
            } else {
                // Update Password
                updateAccountValue($newPassword, 'password', $account['Name']);
                // Clear Input Fields
                $passwords = array('currentPassword' => '', 'newPassword' => '', 'confirmPassword' => '');
            }
        }
    }
}

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
            <h1>Account Information: Password</h1>
            <form method="post" class="change-settings-page">
                <div>
                    <p>
                        Change your account password.
                    </p>
                    <p>
                        Password should be between 4 and 25 characters in length
                    </p>
                    <b>Current Password</b>
                    <input type="password" name="passwords[currentPassword]" value="<?php echo $passwords['currentPassword']; ?>"><span>*</span>
                    <h6><?php echo $errorMes['currentPassword']; ?></h6>

                    <b>New Password</b>
                    <input type="password" name="passwords[newPassword]" value="<?php echo $passwords['newPassword']; ?>"><span>*</span>
                    <h6><?php echo $errorMes['newPassword']; ?></h6>

                    <b>Confirm New Password</b>
                    <input type="password" name="passwords[confirmPassword]" value="<?php echo $passwords['confirmPassword']; ?>"><span>*</span>
                    <h6><?php echo $errorMes['confirmPassword']; ?></h6>

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