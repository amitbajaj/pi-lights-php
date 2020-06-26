<?php
include_once 'code/db.php';
include_once 'code/checkSession.php';
$version = '1.0.00022';
if ($isloggedin){
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
        echo "<title>Welcome to Lights 1.0</title>";
        echo "<script src='scripts/main.js?ver".$version."' type='text/javascript'></script>";
        echo "<link rel='stylesheet' href='css/main.css'/>";
    echo "</head>";
    echo "<body onload='getList();'>";
            echo "<h1>Lights 1.0</h1>";
            echo "<button class='button big-button' onclick='getList();'>Update device list</button>";
            echo "<br><br><select id='list' onchange='adjustToggles(this)'></select>";
            echo "<br><br><button class='button' onclick='doAction(\"start\")'>Start</button>";
            echo "&nbsp;&nbsp;<button class='button' onclick='doAction(\"stop\")'>Stop</button>";
            echo "&nbsp;&nbsp;<button class='button' onclick='doAction(\"shut\")'>Shutdown</button>";
            // echo "&nbsp;&nbsp;<button class='button' onclick='doAction(\"flip\")'>Flip</button>";
            echo '<br><br><br><div id="toggles"></div>';
            echo "<br><br><br><a href='code/logout.php'>Logout</a>";
    echo "</body>";
    echo "</html>";    
}else{
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
        echo "<title>Welcome to Lights 1.0</title>";
        echo "<script src='scripts/login.js' type='text/javascript'></script>";
        echo "<link rel='stylesheet' href='css/main.css'/>";
    echo "</head>";
    echo "<body>";
            echo "<h1>Lights 1.0</h1>";
            echo "<input type='text' id='uid' placeholder='UserId...'/><br><input type='password' id='pass' placeholder='Password...'/><br/><button class='button' onclick='doLogin();'>Login</button>";
    echo "</body>";
    echo "</html>";    
}
?>