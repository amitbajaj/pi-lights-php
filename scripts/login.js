var xhr;
xhr = new XMLHttpRequest();
function doLogin(){
    var frmData = new FormData();
    frmData.append('mode','IN');
    frmData.append('uid',document.getElementById('uid').value);
    frmData.append('pass',document.getElementById('pass').value);
    xhr.open('POST','code/login.php');
    xhr.onreadystatechange=checkResponse;
    xhr.send(frmData);
}

function checkResponse(){
    if(xhr.readyState==4){
        if(xhr.status==200){
            try {
                var json = JSON.parse(xhr.responseText);
                if(json.status=='success'){
                    location.reload();
                }else{
                    alert('Unable to login. Try again.. code[U/P]');
                }
            }catch(ex){
                alert('Unable to login. Try again. code[PE]');
            }
        }else{
            alert('Unable to login. Try again. code[SE]');
        }
    }
}