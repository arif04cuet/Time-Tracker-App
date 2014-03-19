<?php

$host = "localhost";
$user = "outsoux3_time";
$pass = "r?hssG%Fv9Th";
$dbname = "outsoux3_time";
$link = mysql_connect($host, $user, $pass);
if (!$link)
{
    die('Could not connect: ' . mysql_error());
}
$selected = mysql_select_db($dbname);
if (!$selected)
{
    die('Could not select database: ' . mysql_error());
}
?>