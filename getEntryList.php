<?php
function suiteGetEntryList($su,$session,$moduleName,$query='',$orderBy='',$offset=0,$selectFeilds=[],$linkNameToFeildsArray=[],$maxResults=300,$deleted=0,$favourites=0){
    $data=["session" =>  $session,
           "module_name"=>$moduleName,
           "query"=>$query,
           "order_by"=>$orderBy,
           "offset"=>$offset,
           "select_feilds"=>$selectFeilds,
           "link_name_to_feilds_array"=>$linkNameToFeildsArray,
           "max_ressults"=>$maxResults,
           "deleted"=>$deleted,
           "favourites"=>$favourites
          ];
    $su->setMethod('get_entry_list');
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
