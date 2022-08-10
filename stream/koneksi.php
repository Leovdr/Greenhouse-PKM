<?php
$conn = mysqli_connect("localhost", "root", "", "db_hnp");
if(!$conn) {
    die("Conn fail: " . mysqli_connect_error());
}
?>