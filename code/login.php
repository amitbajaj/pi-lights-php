<?php
include 'db.php';
include 'utils.php';
session_start();
header('Content-type: application/json; charset=utf-8');
if ($isconnected){
    if(isset($_POST['uid']) && isset($_POST['pass'])){
        $ip = get_client_ip();
        $sql = 'CALL doLogin("'.$_POST['uid'].'","'.$_POST['pass'].'","'.$ip.'")';
        $result = $conn->query($sql);
        error_log($sql);
        if($result){
            if($row = $result->fetch_assoc()) {
                error_log($row[0]);
                if($row['status']=='1'){
                    echo '{"status":"success"}';
                    $_SESSION['uid']=$_POST['uid'];
                    $_SESSION['status']='success';
                }else{
                    unset($_SESSION['status']);
                    session_abort();
                    echo '{"status":"fail"}';
                }
            }else{
                unset($_SESSION['status']);
                session_abort();
                echo '{"status":"fail"}';
            }
        }else{
            unset($_SESSION['status']);
            session_abort();
            echo '{"status":"fail"}';
        }
    }else{
        session_abort();
        unset($_SESSION['status']);
        echo '{"status":"fail"}';
    }
    $conn->close();
}else{
    session_abort();
    unset($_SESSION['status']);
    echo '{"status":"fail"}';
}
?>