<?php

$formInputs = array(
    'name' => 'Account Name', 'first_name' => 'First Name', 'last_name' => 'Last Name', 'phoneNum' => 'Phone Number',
    'email' => 'Email', 'username' => 'Username (9 digits)', 'password' => 'Password (4 - 6 chars)', 'confirm_password' => 'Confirm Password'
);
// Regular Expressions
$regexes = array(
    'name' => '/^[\w\s!@#$%^&*]{1,24}$/', 'first_name' => '/^[A-Z][a-zA-Z]+$/', 'last_name' => '/^[A-Z][a-zA-Z]+$/',
    'phoneNum' => '/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/',
    'email' => '', 'username' => '/^[\d]{9}$/',
    'password' => '/^[\w(!@#$%\^&*())(<>?\/\\)]{4,6}$/'
);
// Invalid Error Messages
$invalidErrors = array(
    'name' => '*Invalid Name', 'first_name' => '*Invalid Name', 'last_name' => '*Invalid Name',
    'phoneNum' => '*Invalid Phone Number',
    'email' => '*Invalid Email', 'username' => '*Username must be 9 digits',
    'password' => 'Invalid Password (Must be 4 - 6 chars)'
);

// Error Messages
$errors = array(
    'name' => '', 'first_name' => '', 'last_name' => '', 'phoneNum' => '',
    'email' => '', 'username' => '', 'password' => '', 'confirm_password' => ''
);

if (isset($_POST['submit'])) {
    // Pop Off submit input
    unset($_POST['submit']);

    // Filter Submitted Values
    foreach ($formInputs as $key => $val) {
        // Check if Field is empty
        if (!empty($_POST[$key])) {
            // Validate Field Value
            switch ($key) {
                case 'email':
                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                        $errors[$key] = $invalidErrors[$key];
                    break;
                case 'confirm_password':
                    if ($_POST['confirm_password'] !== $_POST['password'])
                        $errors['confirm_password'] = '*Confirmed password does not equal password';
                    break;
                default:
                    if (!preg_match($regexes[$key], $_POST[$key]))
                        $errors[$key] = $invalidErrors[$key];
            }
        } else
            $errors[$key] = "*Field is Empty";
    }
    // If there are no errors add new account
    if (!array_filter($errors)) {
        // Add New Account
        include 'config/sql_functions.php';
        addAccount(
            $_POST['name'],
            $_POST['first_name'] . ' ' . $_POST['last_name'],
            $_POST['phoneNum'],
            $_POST['email'],
            $_POST['username'],
            $_POST['password'],
            ''
        );

        session_start();
        $_SESSION['bLogin'] = true;
        $_SESSION['currentAccount'] = $_POST['name'];

        header("Location: homepage.php");
    }
} else {
    $_POST = array(
        'name' => '', 'first_name' => '', 'last_name' => '', 'phoneNum' => '',
        'email' => '', 'username' => '', 'password' => '', 'confirm_password' => ''
    );
}
?>


<!doctype html>
<html>

<head>
    <title>Create New EPL Account</title>
    <meta name="viewport" content="width=device-width">

    <link href="Stylesheets/style.css" type="text/css" rel="stylesheet">
    <link href="Stylesheets/account.css" type="text/css" rel="stylesheet">

    <script src="scripts/jQuery_3.5.1.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/createAccount_script.js"></script>
</head>

<body>
    <?php include 'templates/header.php' ?>

    <div id="createAccount" class="body-content">
        <!-- Main Page Content -->
        <form method="post">
            <!-- Requires 6 Parameters -->
            <h1>Create a New EPL Account</h1>

            <!-- Input Fields -->
            <ul>
                <?php
                foreach ($formInputs as $name => $field) :
                ?>
                    <li>
                        <h2><?php echo $field; ?></h2>
                        <?php
                        // Get The Type for Input Field
                        $type = '';
                        switch ($name) {
                            case 'password':
                            case 'confirm_password':
                                $type =  'password';
                                break;
                            case 'email':
                                $type = 'email';
                                break;
                            case 'phoneNum':
                                $type = 'tel';
                                break;
                            default:
                                $type = 'text';
                        }
                        ?>
                        <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" value="<?php echo $_POST[$name]; ?>">
                        <p><?php echo $errors[$name]; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <input type="submit" name="submit" value="Create New Account">
        </form>
        <!-- End of Main Content -->
    </div>

    <?php include 'templates/footer.php' ?>
</body>

</html>