<?php
session_start();
if(isset($_SESSION['status'])){
    $isloggedin=true;
}else{
    $isloggedin=false;
}
?>