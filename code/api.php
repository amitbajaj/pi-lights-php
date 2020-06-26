<?php
include_once 'db.php';
header('Content-type: application/json; charset=utf-8');
$message='';
try{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw);
    if ($data!=null){
        $uuid = $data->{'uuid'};
        $name = $data->{'name'};
        $ports = $data->{'ports'};
        // error_log($uuid);
        // error_log($name);
        if ($isconnected){
            $message='Looking for the device in registered list...';
            //error_log($conn->server_info);
            if ($result = $conn->query('CALL getMessage("'.$uuid.'","'.$name.'",'.$ports.')')){
                if($result->num_rows>0){
                    if($row = $result->fetch_assoc()) {
                        $message='{"status":"success","action":"'.$row['message'].'"';
                        // if($row['message']=='speed'){
                            $message.=',"value":"'.$row['value'].'"';
                        // }
                        $message.='}';
                    }else{
                        $message='{"status":"fail","error":"Unable to update database with the device details"}';
                    }
                }else{
                    $message='{"status":"fail","error":"no action"}';
                }
                $result->close();
            }else{
                $message='{"status":"fail","error":"'.$conn->error.'"}';
            }
            $conn->close();
        }else{
            $message='{"status":"fail","error":"Cannot look for the device in the registered list..."}';
        }            
    }else{
        $message='{"status":"fail","error":"Cannot call this without the required details"}'; 
    }
}catch(Exception $e){
    $message='{"status":"fail","error":"Cannot call this without the required details"}'; 
}
echo $message;
?>