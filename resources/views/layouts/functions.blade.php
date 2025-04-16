<?php
//$res=json_decode($listeUrl , true);

function visible ($href,$arr){
    
    $result="none";
    echo checkJson(trim($href),$arr);
    if($href=="#"||checkJson(trim($href),$arr)){
        $result="visible";
    
    }
    return $result;
}
function checkJson($href,$arr){
    $result=false;
    
    foreach($arr as $key=>$value){
       
        if(isset($value["route"]) && $value["route"]==$href){
            $result=true;
            break;
        }
    }
    return $result;
}

?>