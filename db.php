<?php
$conn = new mysqli(
    "dbadmin.r6.websupport.sk",
    "cat_admin",
    "{ZPULWM[O>ie3pNcyODC",
    "catpuchino",
    3306
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>