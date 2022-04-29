<?php

define("TOKEN", "eyJ0eXAiOiJKV1QiLCJub25jZSI6InVOV0pScC00NHdURzZoMW5VTGdTbzZpUzc2YzUtY0dMOGFFU3NLaXp4YUEiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYvIiwiaWF0IjoxNjUxMjU3MDcyLCJuYmYiOjE2NTEyNTcwNzIsImV4cCI6MTY1MTI2MjU2MCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZR0J0Ky83dGFaN1BOVk1PZDFiMlk4V2VuODFscG9oMGxuWUkra21vdmZ6UnZ3a0EiLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6IkVsaXphZ295ZW4gVWdhbGRlIiwiZ2l2ZW5fbmFtZSI6Ik9paGFuYSIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjEzMC4yMDYuMTU4LjE4NyIsIm5hbWUiOiJPaWhhbmEgRWxpemFnb3llbiBVZ2FsZGUiLCJvaWQiOiIxZTNlZjljNC02ODYwLTRmZDMtYWNhNi03MzVmMDYxMjgxNjUiLCJwbGF0ZiI6IjUiLCJwdWlkIjoiMTAwMzIwMDFGMzNFQjU3NSIsInJoIjoiMC5BWUlBaHJZUXF5UmlJa2VneExmbW51WWFSZ01BQUFBQUFBQUF3QUFBQUFBQUFBQ1ZBRnMuIiwic2NwIjoiQm9va2luZ3MuTWFuYWdlLkFsbCBCb29raW5ncy5SZWFkLkFsbCBCb29raW5ncy5SZWFkV3JpdGUuQWxsIEJvb2tpbmdzQXBwb2ludG1lbnQuUmVhZFdyaXRlLkFsbCBvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwiLCJzdWIiOiIwallHNjcyWmxMQjRuc09CTkc3MlZEeWNNc0hDZXZYX1lQOENsamlQYldzIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiYWIxMGI2ODYtNjIyNC00NzIyLWEwYzQtYjdlNjllZTYxYTQ2IiwidW5pcXVlX25hbWUiOiJvaWhhbmFlbGl6YWdveWVuQHVwbmFzaXcub25taWNyb3NvZnQuY29tIiwidXBuIjoib2loYW5hZWxpemFnb3llbkB1cG5hc2l3Lm9ubWljcm9zb2Z0LmNvbSIsInV0aSI6Ii1aY2ZhMG1jR1UyQ2haOUtwV3RQQUEiLCJ2ZXIiOiIxLjAiLCJ3aWRzIjpbIjYyZTkwMzk0LTY5ZjUtNDIzNy05MTkwLTAxMjE3NzE0NWUxMCIsImI3OWZiZjRkLTNlZjktNDY4OS04MTQzLTc2YjE5NGU4NTUwOSJdLCJ4bXNfc3QiOnsic3ViIjoiRXpzMkRXQ0FCZkFqeXZtdXpPUTFzdjZjQ3pndjVKUFZncDdadEtBaHhrdyJ9LCJ4bXNfdGNkdCI6MTY1MDg4MTM4M30.iloJmGa80SDXEliijrjTh9Um7rxjLnxpz-whLtMALF66_92RILHXY28IAd5g9w3t2BvOFtvx43jBjLyLGQQW0j2-L-8b4TkzmMlFtIWs4kmbnnlw7Rg2_dV8dc4n9pTwE07jHl2j-zj9M_0HF6keYMlpqr0PcYBqGoOWUpwEhrRydg8V9BNqeXMmU7Mve-vhB1sQEb-IOTzT5VIr7gNKTgRA4VBiUC_-txUoX_pm9CLLMMYGRN-z0HiVXAQUkaqX7nwfTluiY3o8s-ak6CBBsF8cjEl9v9pAeI-N5D7-igCJnlmNoJoMfVd210Y136egd3Gdqo0OFe8_q_hwRsPrjA");
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

class Curl2
{

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function postGenerate($url, array $data){

        $data_encode = json_encode($data);

        $header = array(
            'Content-Type:application/json',
            'Authorization:Bearer ' . $this->token
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_encode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $resp = curl_exec($ch);

        if($e = curl_error($ch)){
            curl_close($ch);
            return $e;
        }else{
            curl_close($ch);
            return json_decode($resp, true);
        }
    }

}