<?php
include_once 'db.php';
include_once 'checkSession.php';
header('Content-type: application/json; charset=utf-8');
if($isloggedin){
    if(isset($_POST['mode'])){
        switch($_POST['mode']){
        case 'Q':
        case 'q':
            if($isconnected){
                if ($result=$conn->query('CALL getDevices()')){
                    if($result->num_rows>0){
                        $message='{"status":"success","list":[';
                        $isSecond = false;
                        while($row = $result->fetch_assoc()) {
                            if($isSecond){
                                $message.=',';                    
                            }
                            $message.='{"did":"'.$row['id'].'",';
                            $message.='"uuid":"'.$row['uuid'].'",';
                            $message.='"dname":"'.$row['name'].'",';
                            $message.='"ports":'.$row['num_ports'].',';
                            $message.='"lastcomm":"'.$row['last_comm'].'"}';
                            $isSecond=true;
                        }
                        $message.=']}';
                    }else{
                        $message='{"status":"fai","message":"No devices"}';
                    }
                    $result->close();
                }else{
                    $message='{"status":"fail","message":"Unable to get device list. Code [Q]"}';
                }
                $conn->close();
            }else{
                $message='{"status":"fail","message":"Unable to get device list. Code [C]"}';
            }    
            break;
        case 'ACT':
            if($isconnected){
                $msg = $_POST['act'];
                $val = $_POST['val'];
                $id = $_POST['id'];
                if ($result=$conn->query('CALL sendMessage('.$id.',"'.$msg.'","'.$val.'")')){
                    $message='{"status":"success"}';
                }else{
                    $message='{"status":"fail"}';
                }
            }else{
                $message='{"status":"fail"}';
            }
            break;
        default:
            $message='{"status":"fail","message":"Unknown error. Code [UA]"}';
            break;
        }
    }else{
        $message='{"status":"fail","message":"Unknown error. Code [UM]"}';
    }
}else{
    $message='{"status":"fail","message":"Unknown error. Code [NL]"}';
}

echo $message;
?>