<?php

if(!isset($_COOKIE["graph_token"])) {
    //Se puede poner aquí directamente sin la cookie
    define("TOKEN", "token");
} else {
    define("TOKEN", $_COOKIE["graph_token"]);
}
class Curl
{
    private $handler;

    public function postGenerate($url, array $data){
        return $this->init()
            ->setURL($url)
            ->setCustomRequest("POST")
            ->setPostFields($data)
            ->setReturnTransfer()
            ->setHTTPHeader()
            ->obtainResponse();
    }

    public function getGenerate($url){
        return $this->init()
            ->setURL($url)
            ->setCustomRequest("GET")
            ->setReturnTransfer()
            ->setHTTPHeader()
            ->obtainResponse();
    }

    private function init()
    {
        $this->handler = curl_init();
        return $this;
    }

    private function setURL($url)
    {
        curl_setopt($this->handler, CURLOPT_URL, $url);
        return $this;
    }

    private function setCustomRequest($customRequest)
    {
        curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, $customRequest);
        return $this;
    }

    private function setPostFields($data)
    {
        curl_setopt($this->handler, CURLOPT_POSTFIELDS, json_encode($data));
        return $this;
    }

    private function setReturnTransfer()
    {
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
        return $this;
    }

    private function setHTTPHeader()
    {
        $header = array(
            'Content-Type:application/json',
            'Authorization:Bearer ' . TOKEN
        );
        curl_setopt($this->handler, CURLOPT_HTTPHEADER, $header);
        return $this;
    }

    private function execute(){
        return curl_exec($this->handler);
    }

    private function obtainResponse()
    {
        $response = $this->execute();

        if($e = curl_error($this->handler)){
            $this->close();
            return $e;
        }else{
            $this->close();
            return json_decode($response, true);
        }
    }

    private function close()
    {
        curl_close($this->handler);
        return $this;
    }
}