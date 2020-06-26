<?
include 'db.php';
session_start();
if($isconnected){
    $sql = 'CALL doLogout("'.$_SESSION['uid'].'");';
    $conn->query($sql);
    $conn->close();
}
unset($_SESSION['uid']);
unset($_SESSION['status']);
session_destroy();
header("Location: https://bajajtech.in/lights/");
?>