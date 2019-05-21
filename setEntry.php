<?php
function suiteSetEntry($su,$session,$moduleName,$nameValueList){
    $temp=[];
    foreach($nameValueList as $key => $value){
        array_push($temp,["name"=>$key,"value"=>$value]);
    }
    $nameValueList=$temp;
    $data=["session" =>  $session,
           "module_name"=>$moduleName,
           "name_value_list"=>$nameValueList
          ];
    $su->setMethod('set_entry');
    $su->setData($data);
    if($su->start()){
        if(array_key_exists('id',$su->getResponse())){
            return ["success"=>true,"id"=>$su->getResponse()["id"]];
        }
        else{
            return ["success"=>false,'error'=>$su->getResponse()];
        }
    }
    else {
        return ["success"=>false,'error'=>$su->getError()];
    }
}
