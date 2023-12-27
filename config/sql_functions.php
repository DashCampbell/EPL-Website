<?php
include 'db_connection.php';


// Mysqli Syntax
// Back ticks ` : are used for tables and columns
// Double Quotes " : are used to contain sql query
// Single Quotes ' : are used to contain variables

/** Output Eror Message to the Console*/
function logError($mess = 'Error')
{
    echo "<script>console.error(\"$mess\")</script>";
}
/**Log Messages to the console */
function logMessage($mess = '')
{
    echo "<script>console.log(\"$mess\")</script>";
}

/**Get Column Enum Values*/
function retrieveColumnEnum($column, $table)
{
    global $conn;
    $sql = "SHOW COLUMNS FROM `$table` LIKE '$column'";
    $result = mysqli_query($conn, $sql);
    $result_val = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    $enum_str = explode("'", $result_val['Type']);
    $enum = array();
    for ($i = 1; $i < count($enum_str); $i += 2)
        $enum[] = $enum_str[$i];

    return $enum;
}


/**  Get All Item Data from all Items */
function retrieveAllItemData()
{
    global $conn;
    $sql = "SELECT * FROM `epl_item` ORDER BY Title";
    $result = mysqli_query($conn, $sql);

    $return_val = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $return_val;
}

/**  Get All Data of a Specific Item */
function retrieveItemData($title)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $sql = "SELECT * FROM `epl_item` WHERE `Title` = '$title'";
    $result = mysqli_query($conn, $sql) or trigger_error("ERROR[$title]: " . mysqli_error($conn) . '<br/>', E_USER_ERROR);

    if ($result) {
        $return_val = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $return_val;
    }
}

/**  Get Value of One Column from an Item */
function retrieveItemValue($column, $title)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $sql = "SELECT `$column` FROM epl_item WHERE Title = '$title'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $return_val = mysqli_fetch_assoc($result)[$column];
        mysqli_free_result($result);
        return $return_val;
    } else {
        echo "[$title] Does Not Exist<br/>";
        return null;
    }
}

/**  Add New Item */
function addItem($title, $author, $format, $fictional, $subject, $age, $date, $img_type, $copies)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $sql = "INSERT INTO `epl_item` (`Title`, `Author`, `Format`, `Content`, `Subject`, `Age`, `Published Date`, `Cover_URL`, `Copies`) 
    VALUES ('$title', '$author', '$format', '$fictional', '$subject', '$age', '$date', \"images/itemThumbnails/$title.$img_type\", $copies)";

    if (!mysqli_query($conn, $sql))
        echo "Error: [$title] Has Improper Parameters";
}

function updateHolds($title, $nHolds)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);

    $sql = "UPDATE `epl_item` SET `Holds`=$nHolds WHERE `Title`='$title'";

    if (!mysqli_query($conn, $sql))
        echo "ERROR: [$title] does not exist.";
}

/**Deletes a single item. */
function deleteItem($title)
{
    global $conn;
    $sql = "DELETE FROM epl_item WHERE Title = \"$title\"";
    if (!mysqli_query($conn, $sql))
        echo "Error: [$title] doesn't exist!";
}
// Deletes all items
function deleteAllItems()
{
    global $conn;
    $sql = "DELETE FROM epl_item";
    mysqli_query($conn, $sql);
}



// CLIENT FUNCTIONS

/**  Get All Account Data */
function retrieveAllAccountData()
{
    global $conn;
    $sql = "SELECT * FROM `epl_account` ORDER BY `Name`";
    $result = mysqli_query($conn, $sql);

    $return_val = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $return_val;
}

/**  Get All Data of a Specific Account */
function retrieveAccountData($name)
{
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT * FROM `epl_account` WHERE `Name` = '$name'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $return_val = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $return_val;
    } else {
        echo "[$name] Does Not Exist";
        return array();
    }
}

/**  Get Value of One Column from an Account */
function retrieveAccountValue($column, $name)
{
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT `$column` FROM epl_account WHERE `Name` = '$name'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $return_val = mysqli_fetch_assoc($result)[$column];
        mysqli_free_result($result);
        return $return_val;
    } else {
        echo "[$name] Does Not Exist";
        return null;
    }
}

/** Updats Value of One Column from an Account*/
function updateAccountValue($val, $column, $name)
{
    global $conn;
    $val = mysqli_real_escape_string($conn, $val);
    $sql = "UPDATE `epl_account` SET `$column`='$val' WHERE `Name`='$name'";
    mysqli_query($conn, $sql) or trigger_error("ERROR['$name']: " . mysqli_error($conn) . '<br/>', E_USER_ERROR);
}

/**  Add New Account - NOTE: Fines and Date have default values */
function addAccount($name, $fullName, $phone, $email, $username, $password)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $name);

    $phone = mysqli_real_escape_string($conn, $phone);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "INSERT INTO `epl_account`(`Name`, `Full Name`, `Phone Number`, `Email`, `username`, `password`) 
    VALUES ('$name','$fullName','$phone','$email',$username,'$password')";

    mysqli_query($conn, $sql) or trigger_error("ERROR['$name']: " . mysqli_error($conn) . '<br/>', E_USER_ERROR);
}

/**Deletes a single account. */
function deleteAccount($name)
{
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "DELETE FROM epl_account WHERE `Name` = '$name'";
    if (!mysqli_query($conn, $sql))
        echo "Error: [$name] doesn't exist!";
}
// Deletes all accounts
function deleteAllAccounts()
{
    global $conn;
    $sql = "DELETE FROM epl_account";
    mysqli_query($conn, $sql);
}



/**Returns an Array of Account Names that checked out or have the item on hold */
function retrieveItemAccounts($itemName, $bHolds = false)
{
    $allAccounts = retrieveAllAccountData();
    // Array of Names of accounts
    $accounts = array();
    foreach ($allAccounts as $account) {
        if (strpos($account[($bHolds) ? 'hold_Items' : 'checked_Items'], $itemName) !== false)
            $accounts[] = $account['Name'];
    }

    return $accounts;
}

/**Returns an array of item titles from an account
 * \n0    -   CheckOut Items
 * \n1    -   Holds Items
 * \n2    -   Fine Items
 */
function retrieveAccountItems($account, $itemType = 0)
{
    switch ($itemType) {
        case 'C':
        case 0:
            $str = retrieveAccountValue('checked_Items', $account);
            break;
        case 'H':
        case 1:
            $str = retrieveAccountValue('hold_Items', $account);
            break;
        case 'F':
        case 2:
            $str = retrieveAccountValue('Fines', $account);
            break;
        default:
            $str = retrieveAccountValue('checked_Items', $account);
    }

    if (empty($str))
        return array();
    else
        return explode(',', $str);
}
/**Returns a List of Due Dates for checked out items */
function retrieveCheckoutDates($account)
{
    $str = retrieveAccountValue('due_dates', $account);
    if (empty($str))
        return array();
    else
        return explode(',', $str);
}

/**Checks out an Item.
 * If holds exceeds copies than a hold is placed */
function checkOutItem($accountName, $itemName)
{
    global $conn;

    $item = retrieveItemData($itemName);

    // Check if Item is eligible to be checked out
    if ($item['Copies'] > $item['Holds']) {
        // Item is eligible
        // Check if there are no items in checkedItems
        if (strlen(retrieveAccountValue('checked_Items', $accountName)) > 0)
            $itemChecks = retrieveAccountValue('checked_Items', $accountName) . ',' . $itemName;
        else
            $itemChecks = $itemName;

        $itemChecks = mysqli_real_escape_string($conn, $itemChecks);

        $sql = "UPDATE `epl_account` SET `checked_Items`='$itemChecks' WHERE `Name`='$accountName'";


        // # of Seconds in a day
        $daySecs = 86400;
        // Set Due Date

        $dueDate = date('Y-m-d',  time() + ($daySecs * 8));
        if (strlen(retrieveAccountValue('due_dates', $accountName)) > 0)
            $dateList = retrieveAccountValue('due_dates', $accountName) . ',' . $dueDate;
        else
            $dateList = $dueDate;
        $dateSql = "UPDATE `epl_account` SET `due_dates`='$dateList' WHERE `Name`='$accountName'";
        mysqli_query($conn, $dateSql);
    } else {
        // Put Item On Hold
        if (strlen(retrieveAccountValue('hold_Items', $accountName)) > 0)
            $itemHolds = retrieveAccountValue('hold_Items', $accountName) . ',' . $itemName;
        else
            $itemHolds = $itemName;

        $itemHolds = mysqli_real_escape_string($conn, $itemHolds);

        $sql = "UPDATE `epl_account` SET `hold_Items`='$itemHolds' WHERE `Name`='$accountName'";
    }
    mysqli_query($conn, $sql);
    updateHolds($itemName, $item['Holds'] + 1);
}


/**Renews an Item */
function renewItem($account, $title)
{
    global $conn;
    $checkItems = retrieveAccountItems($account);
    $dueDates = retrieveCheckoutDates($account);

    $index = array_search($title, $checkItems);

    // Extend Due Date by 1 Week
    $dueDates[$index] = date('Y-m-d', strtotime($dueDates[$index]) + (86400 * 7));

    $dueDates = mysqli_real_escape_string($conn, implode(',', $dueDates));

    $sql = "UPDATE `epl_account` SET `due_dates`='$dueDates' WHERE `Name`='$account'";
    mysqli_query($conn, $sql);
}

/**Cancels an Item Hold */
function cancelHold($account, $title)
{
    global $conn;
    $holdItems = retrieveAccountItems($account, 1);

    $index = array_search($title, $holdItems);

    array_splice($holdItems, $index, 1);

    $holdItems = mysqli_real_escape_string($conn, implode(',', $holdItems));

    $sql = "UPDATE `epl_account` SET `hold_items`='$holdItems' WHERE `Name`='$account'";
    mysqli_query($conn, $sql);
}
