<?php
function openConn(){
    $dbhost = "127.0.0.1";
    $dbdatabase = "employee_management";
    $dbusername = "root";
    $dbpassword = "";
    $dbport = "3306";

    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbdatabase, $dbport);
    if ($conn -> connect_error) {
        echo 'koneksi error '. $conn->connect_error;
        header("location:error.php");
    }else {
        return $conn;
    }
}
?>