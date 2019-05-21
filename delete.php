<?php
function suiteDelete($su,$session,$moduleName,$id){
    $nameValueList=[['name'=>'id','value'=>$id],['name'=>'deleted','value'=>1]];
    $data=['session' =>  $session,
           'module_name'=>$moduleName,
           'name_value_list'=>$nameValueList
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
