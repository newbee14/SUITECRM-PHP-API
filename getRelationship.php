<?php
function suiteGetRelationship($su,$session,$moduleName,$moduleId,$linkFieldName,$relatedFields,$relatedModuleQuery="",$relatedModuleLinkNameToFeildsArray=[],$deleted=0,$orderBy="",$offset=0,$limit=300){
    $data=["session" =>  $session,
           "module_name"=>$moduleName,
           "module_id"=>$moduleId,
           "link_field_name"=>$linkFieldName,
           "related_module_query"=>$relatedModuleQuery,
           "related_fields"=>$relatedFields,
           "related_module_link_name_to_feilds_array"=>$relatedModuleLinkNameToFeildsArray,
           "deleted"=>$deleted,
           "order_by"=>$orderBy,
           "offset"=>$offset,
           "limit"=>$limit
          ];
    $su->setMethod('get_relationships');
    $su->setData($data);
    if($su->start()){
        if(array_key_exists('entry_list',$su->getResponse())) {
            $result=$su->getResponse();
            foreach($result['entry_list'] as &$record){
                $temp=[];
                foreach($record['name_value_list'] as $name => $valObj){
                    $temp=array_merge($temp,[$name=>$valObj['value']]);
                }
                $record=$temp;
            }
            return ["success"=>true,"result"=>$result];
        }
        else{
            return ["success"=>false,'error'=>$su->getResponse()];
        }
    }
    else {
        return ["success"=>false,'error'=>$su->getError()];
    }
}
