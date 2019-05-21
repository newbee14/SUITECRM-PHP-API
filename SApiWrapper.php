<?php
require_once "RestCurl.php";
class SApiWrapper{
    private $method=null;
    private $url=null;
    private $data=null;
    private $response=null;
    private $curl= null;
    private $error= null;
    function __construct($method=null){
        //require __DIR__.'/../config.php';
        $this->url='http://localhost/crm/service/v4/rest.php';
        if(isset($method)) {
            $this->method=$method;
        }
    }
    function setMethod($method){
        $this->method=$method;
    }
    function setUrl($url){
        $this->url=$url;
    }
    function setData($data){
        $data=json_encode($data);
        if (isset($this->method)) {
        $post = array(
            "method" => $this->method,
            "input_type" => "JSON",
            "response_type" => "JSON",
            "rest_data" => $data
        );
        $this->data=$post;
        }
        else {
            throw new Exception('Error: No method provided for calling');
        }
    }
    function start(){
        try{
            $this->curl=new RestCurl($this->url);
            $this->curl->setMethod("post");
            $this->curl->setEncodeType("text");
            $this->curl->addHeader(["content-type: application/x-www-form-urlencoded"]);
            $this->curl->setData($this->data);
            if($this->curl->start()){
                $result=$this->curl->getResponse();
                $this->response= json_decode($result,true);
                return true;
            }
            else{
                return false;
            }
        }
        catch (Exception $e){
            $this->error=$e->getMessage();
            return false;
        }
    }
    function getResponse(){
        return $this->response;
    }
    function getError(){
        return $this->error;
    }
}
?>
