<?php

//connect to database
$conn = mysqli_connect('localhost', 'new_user', '1234', 'epl');

if (!$conn) {
    echo "Connection Error: " . mysqli_connect_error();
}

function closeConnection()
{
    global $conn;
    mysqli_close($conn);
}
