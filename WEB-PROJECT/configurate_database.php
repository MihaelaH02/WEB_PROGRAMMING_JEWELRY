<?php
    $host= 'localhost';
    $dbUser= 'root';
    $dbPass= '';

    if (!$dbConn=mysqli_connect($host, $dbUser, $dbPass))
        die('Не може да се осъществи връзка със сървъра.');

    $sql = 'CREATE Database IF NOT EXISTS e_commerce';
    if (!$queryResource=mysqli_query($dbConn,$sql))
        die('Не може да се създаде базата от данни.');
    
     if (!mysqli_select_db($dbConn,'e_commerce'))
        die('Не може да се селектира базата от данни.');
     mysqli_query($dbConn,"SET NAMES 'UTF8'");
?>
