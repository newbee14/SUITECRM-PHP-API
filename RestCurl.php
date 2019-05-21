<?php
class RestCurl {

    private $url = null;      // to store url
    private $data = null;         // to store data
    private $encodeType = "text";     // Default: application/x-www-form-urlencoded
    private $response = null;  // to store the response
    private $headers=null; // to store value of header
    private $method=null;  //to store method value
    private $error=null;
    public function __construct($url)
    {
        if (!empty($url)) {
            $this->url = $url;
        }
    }
    public function setEncodeType($encodeType) //sets the encode type input:(encode type to be set) return:(sets the encode type)
    {
        if (!empty($encodeType))
            $this->encodeType = $encodeType;
        else
            $this->encodeType = 'text';
    }
    public function setData($data) //sets the data to be sent input:(data to be set) return:(sets the data to be sent)
    {
            $this->data = $data;
    }
    public function addHeader($header) //sets the headers to be sent input:(headers to be set) return:(sets the headers)
    {
        if (!empty($header))
            $this->headers = $header;
    }
    public function setMethod($method) //sets the method to be use in post input:(method to be set) return:(sets the method)
    {
        if (!empty($method))
            $this->method = $method;
    }
    public function setUrl($url){
        if (!empty($url))
            $this->url = $url;
    }
    public function start()  //starts the rest call input:(none) return:(starts the rest call)
    {
        try{
            // If URL is not Empty, then make Request
            if (!empty($this->url)) {
                $conn = curl_init(); // Initialize Connection
                curl_setopt($conn, CURLOPT_URL, $this->url);
                if(!empty($this->data)){   //if data is provided
                    $postData = "";
                    if (strtolower($this->encodeType) == "json")
                        $postData = json_encode($this->data);  // json encoding of data

                    else if (strtolower($this->encodeType) == "text")
                        $postData = http_build_query($this->data);  //simple text encodin
                    else if (strtolower($this->encodeType) == "xml")
                        $postData = $this->data;    //for xml


                    if (strtolower($this->method) === strtolower('post'))   //for post
                    {
                        curl_setopt($conn, CURLOPT_POST, 1);
                    }
                    else  if (strtolower($this->method) === strtolower('put'))  //for put
                    {
                        curl_setopt($conn, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($conn, CURLOPT_HEADER, false);
                    }
                    curl_setopt($conn, CURLOPT_POSTFIELDS, $postData); // Post Data
                }
                else {  //if no data is provided then that could be post, get or delete request
                    
                    if (strtolower($this->method) === strtolower('post'))   //for post
                    {
                        $postData = "";
                        if (strtolower($this->encodeType) == "json")
                            $postData = json_encode($this->data);  // json encoding of data

                        else if (strtolower($this->encodeType) == "text")
                            $postData = http_build_query($this->data);  //simple text encodin
                        else if (strtolower($this->encodeType) == "xml")
                            $postData = $this->data;    //for xml
                        curl_setopt($conn, CURLOPT_POST, 1);
                        curl_setopt($conn, CURLOPT_POSTFIELDS, $postData); // Post Data
                    }
                    else if (strtolower($this->method) === strtolower('get')){   //for get
                        curl_setopt($conn, CURLOPT_CUSTOMREQUEST, "GET");
                    }
                    else if (strtolower($this->method) === strtolower('delete')){   //for delete
                        curl_setopt($conn, CURLOPT_CUSTOMREQUEST, "DELETE");
                    }
                }
                if (!empty($this->headers)) {
                    curl_setopt($conn, CURLOPT_HTTPHEADER, $this->headers);
                }
                curl_setopt($conn, CURLOPT_RETURNTRANSFER, true); // Receive Server Response
                $this->response = curl_exec($conn); // Make Request
                if(curl_error($conn)){  //get curl errors
                    $this->error=curl_error($conn);
                    return false;
                }
                curl_close ($conn); // Close curl connection
                return true;
            }
            else{
                throw new Exception('Function start called without setting url while creating object of Class RestCurl');
            }
        }
        catch(Exception $e){
            $this->error=["error"=>$e->getMessage()];
            return false;
        }
    }
    public function getResponse()    //method to return the response of rest api call input:(none) return:(sets the response of rest call)
    {
        return $this->response;
    }
    public function getError()    //method to return the Error
    {
        return $this->error;
    }
}
?>
