<?php
function suiteSetRelationship($su,$session,$moduleName,$moduleId,$linkFieldName,$ids,$delete=0,$nameValueList=[]){
    $data=["session" =>  $session,
           "module_name"=>$moduleName,
           "id"=>$moduleId,
           "link_field_name"=>$linkFieldName,
           "related_ids"=>$ids,
           "name_value_list"=>$nameValueList,
           "delete"=>$delete
          ];
    $su->setMethod('set_relationship');
    $su->setData($data);
    if($su->start()){
            $result=$su->getResponse();
            return ["success"=>true,"result"=>$result];
    }
    else {
        return ["success"=>false,'error'=>$su->getError()];
    }
}
