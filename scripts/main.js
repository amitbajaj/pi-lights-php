var xhrList, xhrStart, xhrStop, xhrShutdown, xhrAction;
xhrList = new XMLHttpRequest();
function adjustToggles(tgl){
    if(tgl.selectedIndex == 0){
        document.getElementById('toggles').innerHTML = '';
    }else{
        var toggleCount = parseInt(tgl.options[tgl.selectedIndex].tag);
        var toggleHTML = '';
        for(i=0;i<toggleCount;i++,toggleHTML+='&nbsp;'){
            toggleHTML += '<label class="switch"><input type="checkbox" id="tgl'+i+'"><span class="slider round"></span></label>';
        }
        toggleHTML += '&nbsp;<button class="button" onclick="doFlip()">Flip</button>';
        document.getElementById('toggles').innerHTML = toggleHTML;
    }
    
}

function doFlip(){
    var i =0;
    var val = '';
    while(tgl = document.getElementById('tgl'+i)){
        if(tgl.checked){
            if (val!='') val+=',';
            val+=(tgl.checked?i:'');
        }
        i++;
    }
    doAction('flip',val);
}
function getList(){
    var frmData = new FormData();
    frmData.append('mode','Q');
    xhrList.open('POST','code/data.php');
    xhrList.onreadystatechange=checkResponse;
    xhrList.send(frmData);
}

function checkResponse(){
    if(xhrList.readyState==4){
        if(xhrList.status==200){
            try {
                var json = JSON.parse(xhrList.responseText);
                if(json.status=='success'){
                    var lst = document.getElementById('list');
                    while(lst.options.length>0) lst.options.remove(0);
                    list.options.add(new Option("Select a relay"));
                    json.list.forEach(item => {
                        var opt = new Option(item['dname']+' : '+item['uuid']+' ('+item['ports']+') ['+item['lastcomm']+']',item['did']);
                        opt.tag = parseInt(item['ports']);
                        list.options.add(opt);
                        //sHTML+='<li>'+item[0]+':'+item[2]+':'+item[1]+'</li>'
                    });
                    //sHTML+='</ul>';
                    //document.getElementById('list').innerHTML = sHTML;
                }
            }catch(ex){
                alert(ex);
            }
        }
    }
}

xhrStart = new XMLHttpRequest();
function startDevice(){
    var frmData = new FormData();
    frmData.append('mode','STRT');
    frmData.append('id',document.getElementById('list').value);
    xhrStart.open('POST','code/data.php');
    xhrStart.onreadystatechange=checkStartResponse;
    xhrStart.send(frmData);
}

function checkStartResponse(){
    if(xhrStart.readyState==4){
        if(xhrStart.status==200){
            var json = JSON.parse(xhrStart.responseText);
            if(json.status=='success'){
                alert('Device start message delivered!');
            }else{
                alert('Unable to submit the start message!');
            }
        }else{
            alert('Unable to start device. code[SE]');
        }
    }
}

xhrStop = new XMLHttpRequest();
function stopDevice(){
    var frmData = new FormData();
    frmData.append('mode','STOP');
    frmData.append('id',document.getElementById('list').value);
    xhrStart.open('POST','code/data.php');
    xhrStart.onreadystatechange=checkStopResponse;
    xhrStart.send(frmData);
}

function checkStopResponse(){
    if(xhrStart.readyState==4){
        if(xhrStart.status==200){
            var json = JSON.parse(xhrStart.responseText);
            if(json.status=='success'){
                alert('Device stop message delivered!');
            }else{
                alert('Unable to submit the stop message!');
            }
        }else{
            alert('Unable to stop device. code[SE]');
        }
    }
}

xhrShutdown = new XMLHttpRequest();
function stopDevice(){
    var frmData = new FormData();
    frmData.append('mode','SHUT');
    frmData.append('id',document.getElementById('list').value);
    xhrStart.open('POST','code/data.php');
    xhrStart.onreadystatechange=checkStopResponse;
    xhrStart.send(frmData);
}

function checkStopResponse(){
    if(xhrStart.readyState==4){
        if(xhrStart.status==200){
            var json = JSON.parse(xhrStart.responseText);
            if(json.status=='success'){
                alert('Device stop message delivered!');
            }else{
                alert('Unable to submit the stop message!');
            }
        }else{
            alert('Unable to stop device. code[SE]');
        }
    }
}

xhrAction = new XMLHttpRequest();
var lstAction='';
var bPendingAction=false;
function doAction(act,val){
    if (bPendingAction){
        alert('Previous action: '+lstAction+' is still pending...');
        return;
    }else{
        bPendingAction=true;
    }
    var frmData = new FormData();
    lstAction = act
    frmData.append('mode','ACT');
    frmData.append('act',act);
    frmData.append('val',val);
    frmData.append('id',document.getElementById('list').value);
    xhrStart.open('POST','code/data.php');
    xhrStart.onreadystatechange=checkStopResponse;
    xhrStart.send(frmData);
}

function checkStopResponse(){
    if(xhrStart.readyState==4){
        if(xhrStart.status==200){
            var json = JSON.parse(xhrStart.responseText);
            if(json.status=='success'){
                alert('Device '+lstAction+' message delivered!');
            }else{
                alert('Unable to submit the '+lstAction+' message! code[F]');
            }
        }else{
            alert('Unable to '+lstAction+' device. code[SE]');
        }
        bPendingAction=false;
    }
}