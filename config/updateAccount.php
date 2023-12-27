<?php
if (isset($_POST['submit'])) {
    $input = $_POST['column'];
    if (empty($_POST['column'])) {
        // Check if Field is Empty
        $errorMes = $errors['empty'];
    } else {
        // Check if Field is Invalid
        if (!validate($_POST['column']))
            $errorMes = $errors['invalid'];
        else {
            // Update User Info
            updateAccountValue($_POST['column'], $column, $account['Name']);
        }
    }
}
