<?php
function suiteLogin($su,$user=null,$pass=null){
    //chdir(__DIR__.'/..');
    //require "config.php";
    $data=["user_auth" => [
        "user_name" => $user,
        "password" => $pass,
        "version" => "1"
    ],
           "application_name" => "RestTest",
           "name_value_list" => []];
    $su->setMethod('login');
    $su->setData($data);
    if($su->start()){
        return ["success"=>true,"id"=>$su->getResponse()["id"]];
    }
    else {
        return ["success"=>false,'error'=>$su->getError()];
    }
}
