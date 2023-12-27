<?php
include 'config/sql_functions.php';

function randArray(array $array)
{
    return $array[rand(0, count($array) - 1)];
}

// UPDATE ITEMS

$authors = [
    "J.K Rowling", "John Bone", "Geralt Rich", "Britney White", "Zack Bill",
    "Gary Prick", "John Lewis", "Wester Link", "Frickles Dinkler", "Walter Steel"
];
$formats = [
    "Book", "Movie", "Videogame", "Music", "eBook", "AudioBook"
];
$fictional = [
    "Fiction", "Nonfiction"
];
$subjects = [
    "Art & Literature", "Finance", "Research", "Biography"
];
$ages = [
    "Adult", "Teen", "Kids 6-12", "Kids 1-6"
];


// Get All News Panel Names
$coverDir = "images/itemThumbnails";
$titles = array();

if (is_dir($coverDir)) {
    if ($handler = opendir($coverDir)) {
        while (($file = readdir($handler)) != false) {
            array_push($titles, $file);
        }
        closedir($handler);
    }
}
array_splice($titles, 0, 2);

/**Returns random array element*/
function rArray(&$array)
{
    return $array[rand(0, count($array) - 1)];
}
deleteAllItems();

$itemTitles = array();
// Add New Items
foreach ($titles as $title) {
    $file = explode('.', $title);
    echo '<br/>';
    // Checks if there are multiple periods in file name
    if (count($file) > 2) {
        $temp_file = array($file[0] . '.', $file[count($file) - 1]);
        for ($i = 1; $i < count($file) - 3; $i++) {
            $temp_file[0] = $temp_file[0] . $file[$i] . '.';
        }
        $temp_file[0] = $temp_file[0] . $file[count($file) - 2];

        $file = $temp_file;
    }
    $itemTitles[] = $file[0];
    print_r($file);

    $year = rand(1950, 2020);

    $month = rand(1, 12);
    $month = ($month > 9) ? $month : '0' . $month;

    $day = rand(1, 28);
    $day = ($day > 9) ? $day : '0' . $day;

    $date = $year . '-' . $month . '-' . $day;

    $copies = rand(1, 10);

    addItem(
        $file[0],
        rArray($authors),
        rArray($formats),
        rArray($fictional),
        rArray($subjects),
        rArray($ages),
        $date,
        $file[1],
        $copies
    );
}
echo '<br/><br/><br/>';



// UPDATE CLIENTS(8 Clients)
// TODO: Add Clients, and check out items

$accountName = ['Putin', 'Stalin', 'Mao', 'Kao', 'Dante', 'Chunky Steve', 'Fat Billy', 'Skinny Ted'];

$firstNames = ['Gary', "Harry", 'Birt', 'John', 'Steve', 'Jessie', 'Ellie', 'Shawnae'];
$lastNames = ['Bill', 'Fetcher', 'Prick', 'Still', 'Bella', 'Dog'];

$emailRoot = ['shaw.ca', 'gmail.com', 'franks.uk'];

$passwordChars = 'abcdefghijklmnopqrstuxyzABCDEFGHIJKLMNOPQRSTUXY@#%&*?_0123456789';

// Delete Previous Clients
deleteAllAccounts();

// Add New Clients
$itemIndexes = range(0, count($titles) - 1);

foreach ($accountName as $name) {
    // Set Up Fields

    // 9 Digit username
    $username = rand(1e8, 1e9 - 1);

    // password 4 - 6 chars
    $password = '';
    for ($i = 0; $i < rand(4, 6); $i++)
        $password .= $passwordChars[rand(0, strlen($passwordChars) - 1)];

    // Full Name
    $fullName = randArray($firstNames) . ' ' . randArray($lastNames);

    // Email
    $email =  str_replace(' ', '', $fullName) . '@' . randArray($emailRoot);

    // Phone Number
    $phoneNum = rand(1e9, 1e10 - 1);

    addAccount($name, $fullName, $phoneNum, $email, $username, $password);

    // Pickup Random Items
    shuffle($itemIndexes);

    for ($i = 0; $i < rand(6, 12); $i++) {
        checkOutItem($name, $itemTitles[$itemIndexes[$i]]);
    }

    echo "Added New Account: $name<br/>";
}
addAccount('Fatty Joe', 'Joe Stiff', '999-000-6666', 'joe@gmail.ca', 333666999, '1234');
echo "Added New Account: Joe Stiff<br/>";

// Unset Session Variables
session_start();
$_SESSION = array();

closeConnection();
