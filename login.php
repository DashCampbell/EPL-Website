<?php
include 'config/sql_functions.php';

session_start();

$errors = array('username' => '', 'password' => '', 'other' => '');
$username = $password = '';

// Check if Submit button was clicked
if (isset($_POST['submit'])) {
    // Array of accounts for username and password
    $accounts = array('username' => '', 'password' => '');

    // Check if input fields were filled in
    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
        // Check if username is valid
        if (!preg_match('/^[\d]{9}$/', $username))
            $errors['username'] = 'Username is Invalid (9 digits)';
        else {
            // Confirm Username
            $allAccounts = retrieveAllAccountData();
            foreach ($allAccounts as $account) {
                if ($account['username'] === $username) {
                    $accounts['username'] = $account['Name'];
                    break;
                }
            }
            if (empty($accounts['username']))
                $errors['username'] = 'Username does not exist';
        }
    } else
        $errors['username'] = "Username Required";

    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        if (!preg_match('/^[\w(!@#$%\^&*())(<>?\/\\)]{4,6}$/', $password))
            $errors['password'] = 'Password is Invalid (4 - 6 characters)';
        else {
            // Confirm Username
            $allAccounts = retrieveAllAccountData();
            foreach ($allAccounts as $account) {
                if ($account['password'] === $password) {
                    $accounts['password'] = $account['Name'];
                    break;
                }
            }
            if (empty($accounts['password']))
                $errors['password'] = 'Password does not exist';
        }
    } else
        $errors['password'] = "Password Required";

    // Check if there are no errors in any field
    if (!array_filter($errors)) {
        if ($accounts['username'] === $accounts['password']) {
            $_SESSION['bLogin'] = true;
            $_SESSION['currentAccount'] = $accounts['username'];
            // Default Page is homepage, if redirected from an account page go to previous page
            header("Location: " . (isset($_GET['prevPage']) ? $_GET['prevPage'] : "homepage.php"));
        } else
            $errors['other'] = 'Username or Password was Incorrect';
    }
}
?>

<!doctype html>
<html>

<head>
    <title>Login | Edmonton Public Library</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">
    <link href="Stylesheets/account.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
    <script src="scripts/script.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <div id="login-page" class="body-content">
        <!-- Main Page Content -->
        <form method="post">
            <h1>Login</h1>

            <p><?php echo $errors['other']; ?></p>

            <h2>Username or Barcode:</h2>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username) ?>">
            <!-- Error Message -->
            <p><?php echo $errors['username']; ?></p>

            <h2>Password:</h2>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
            <!-- Error Message -->
            <p> <?php echo $errors['password']; ?></p>

            <br>

            <input type="submit" name="submit" value="Login">
            <a href="createAccount.php">Get a Library Card</a>
        </form>
        <!-- End of Main Content -->
    </div>

    <?php include 'templates/footer.php' ?>
</body>

</html>