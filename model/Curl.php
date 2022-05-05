<?php

if(!isset($_COOKIE["graph_token"])) {
    //Se puede poner aquí directamente sin la cookie
    define("TOKEN", "eyJ0eXAiOiJKV1QiLCJub25jZSI6IlFrT2ZuSlprUXJnUjN0dmRPM2RCR2xxWmhZaloxUW1PTnMweGs2eEtma0UiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYvIiwiaWF0IjoxNjUxNjAxNTkyLCJuYmYiOjE2NTE2MDE1OTIsImV4cCI6MTY1MTYwNjg1NiwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZUGplb1ZmYS9MUTEwUDIwWU1FdXMrc3VwelF5aEQ4bTJ5enFYSGwzd1J5M1ltTUEiLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6IkVsaXphZ295ZW4gVWdhbGRlIiwiZ2l2ZW5fbmFtZSI6Ik9paGFuYSIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjgxLjkuMjExLjIwNyIsIm5hbWUiOiJPaWhhbmEgRWxpemFnb3llbiBVZ2FsZGUiLCJvaWQiOiIxZTNlZjljNC02ODYwLTRmZDMtYWNhNi03MzVmMDYxMjgxNjUiLCJwbGF0ZiI6IjUiLCJwdWlkIjoiMTAwMzIwMDFGMzNFQjU3NSIsInJoIjoiMC5BWUlBaHJZUXF5UmlJa2VneExmbW51WWFSZ01BQUFBQUFBQUF3QUFBQUFBQUFBQ1ZBRnMuIiwic2NwIjoiQm9va2luZ3MuTWFuYWdlLkFsbCBCb29raW5ncy5SZWFkLkFsbCBCb29raW5ncy5SZWFkV3JpdGUuQWxsIEJvb2tpbmdzQXBwb2ludG1lbnQuUmVhZFdyaXRlLkFsbCBEaXJlY3RvcnkuUmVhZC5BbGwgRGlyZWN0b3J5LlJlYWRXcml0ZS5BbGwgb3BlbmlkIHByb2ZpbGUgVXNlci5SZWFkIFVzZXIuUmVhZC5BbGwgVXNlci5SZWFkQmFzaWMuQWxsIFVzZXIuUmVhZFdyaXRlIFVzZXIuUmVhZFdyaXRlLkFsbCBlbWFpbCIsInN1YiI6IjBqWUc2NzJabExCNG5zT0JORzcyVkR5Y01zSENldlhfWVA4Q2xqaVBiV3MiLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiRVUiLCJ0aWQiOiJhYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYiLCJ1bmlxdWVfbmFtZSI6Im9paGFuYWVsaXphZ295ZW5AdXBuYXNpdy5vbm1pY3Jvc29mdC5jb20iLCJ1cG4iOiJvaWhhbmFlbGl6YWdveWVuQHVwbmFzaXcub25taWNyb3NvZnQuY29tIiwidXRpIjoiUkhPZ1hwZ2JWVUNfX3J0YlQ0eURBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiNjJlOTAzOTQtNjlmNS00MjM3LTkxOTAtMDEyMTc3MTQ1ZTEwIiwiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiJFenMyRFdDQUJmQWp5dm11ek9RMXN2NmNDemd2NUpQVmdwN1p0S0FoeGt3In0sInhtc190Y2R0IjoxNjUwODgxMzgzfQ.FfgXSAp73dadoBCyq5N-myBBv7XGVpSrHdoRBYV35-Bf_dtPNf6gpGLgowCKj5lUxkpkxa2_u32hjldFya1gLu5GWzRNEY3uQ2wbbQZ4Y8YfluERms5hPgRF2Str0grmLcqu2jXFxYnNVUsfZwwjMERo8fzAWSWXSd3i_11wTniAtBOyFKYudI_PWuchped-xLo7E-D4Qbmfdr2TokMJlkN0243oigFV_flWgyMUYsx3jzflMANLtjWIE_8jbnN3worqXL2wQdQ7Re87hiTvXSiL3B-t3HabxfgH4cRmnAIN1fJR8yuDpoOPQed8KlS_lWP1uXbSKAS_-miBPaXC7Q");
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
    public function patchGenerate($url, array $data){
        return $this->init()
            ->setURL($url)
            ->setCustomRequest("PATCH")
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