<?php

define("TOKEN", "eyJ0eXAiOiJKV1QiLCJub25jZSI6IlcxblNua3VVcDdTdVA0Ui1LdW5pbHZtbjBRLTBWRGhtZzNWT3RFel9iOVkiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYvIiwiaWF0IjoxNjUwOTg4MjE0LCJuYmYiOjE2NTA5ODgyMTQsImV4cCI6MTY1MDk5Mjg1OCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFTUUEyLzhUQUFBQWE1N3VEUWVRcWM2SytBNXFHU2lESUtrM3JoUFk2TEpIclFTOENnUE05OG89IiwiYW1yIjpbInB3ZCJdLCJhcHBfZGlzcGxheW5hbWUiOiJHcmFwaCBFeHBsb3JlciIsImFwcGlkIjoiZGU4YmM4YjUtZDlmOS00OGIxLWE4YWQtYjc0OGRhNzI1MDY0IiwiYXBwaWRhY3IiOiIwIiwiZmFtaWx5X25hbWUiOiJFbGl6YWdveWVuIFVnYWxkZSIsImdpdmVuX25hbWUiOiJPaWhhbmEiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiIxNzIuMjI1LjE2My41MiIsIm5hbWUiOiJPaWhhbmEgRWxpemFnb3llbiBVZ2FsZGUiLCJvaWQiOiIxZTNlZjljNC02ODYwLTRmZDMtYWNhNi03MzVmMDYxMjgxNjUiLCJwbGF0ZiI6IjUiLCJwdWlkIjoiMTAwMzIwMDFGMzNFQjU3NSIsInJoIjoiMC5BWUlBaHJZUXF5UmlJa2VneExmbW51WWFSZ01BQUFBQUFBQUF3QUFBQUFBQUFBQ1ZBRnMuIiwic2NwIjoiQm9va2luZ3MuTWFuYWdlLkFsbCBCb29raW5ncy5SZWFkLkFsbCBCb29raW5ncy5SZWFkV3JpdGUuQWxsIEJvb2tpbmdzQXBwb2ludG1lbnQuUmVhZFdyaXRlLkFsbCBvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwiLCJzdWIiOiIwallHNjcyWmxMQjRuc09CTkc3MlZEeWNNc0hDZXZYX1lQOENsamlQYldzIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiYWIxMGI2ODYtNjIyNC00NzIyLWEwYzQtYjdlNjllZTYxYTQ2IiwidW5pcXVlX25hbWUiOiJvaWhhbmFlbGl6YWdveWVuQHVwbmFzaXcub25taWNyb3NvZnQuY29tIiwidXBuIjoib2loYW5hZWxpemFnb3llbkB1cG5hc2l3Lm9ubWljcm9zb2Z0LmNvbSIsInV0aSI6Ii1JeTk4X0NUVzBDY2xGQzNqX1lVQUEiLCJ2ZXIiOiIxLjAiLCJ3aWRzIjpbIjYyZTkwMzk0LTY5ZjUtNDIzNy05MTkwLTAxMjE3NzE0NWUxMCIsImI3OWZiZjRkLTNlZjktNDY4OS04MTQzLTc2YjE5NGU4NTUwOSJdLCJ4bXNfc3QiOnsic3ViIjoiRXpzMkRXQ0FCZkFqeXZtdXpPUTFzdjZjQ3pndjVKUFZncDdadEtBaHhrdyJ9LCJ4bXNfdGNkdCI6MTY1MDg4MTM4M30.cxBRdlXw31D_RBEJGtiqeqrKtqSgQITVtLHLkjqCGIhB122RgpHzqIz_GCXqNI3GtwleNOphkiWH7PaeWgyCfkQYqHcGwxa0B1X9wHl8L31wr59_5uqFNHTfk_0ktE1idCSPlZ6awDy_yhZpF-WmdNxEEX8VM_ONpcRWCPC20sejvoR6NIjP1YGoY21IawI0SKnBhtkV00waW8l5MD19JJGKvWPqEAcXsLVmX6IW1UdqLBjAx20SBRKlZ6RDJHZEYcFqphJLeva6QxgmdY_4fdsnbY0-t0YOawhmjF3W-gMdMBmBbnzGShRvS7NdWemaL74W68nh4ThgWaO_6I6RxA");
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

$curl = new Curl();
$data_array = [
    'displayName' => 'empresaEEEE'
];
$respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses', $data_array);

var_dump($respuesta);