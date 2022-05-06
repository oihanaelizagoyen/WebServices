<?php

if(!isset($_COOKIE["graph_token"])) {
    //Se puede poner aquí directamente sin la cookie
    define("TOKEN", "eyJ0eXAiOiJKV1QiLCJub25jZSI6InZsNDhGX3h5aHRqMExtdUFESUJaR3hFcEs1ZEoyNU93b0F2OVB0N2R2RDgiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYvIiwiaWF0IjoxNjUxODM5NDM5LCJuYmYiOjE2NTE4Mzk0MzksImV4cCI6MTY1MTg0NTAyNiwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZRGgwU0hUK1R0MkxCcUtybG13V01vbTNaV0NjK2FCUHZ2KzlaVVgwZFllMEU0b0EiLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6IkVsaXphZ295ZW4gVWdhbGRlIiwiZ2l2ZW5fbmFtZSI6Ik9paGFuYSIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjEzMC4yMDYuMTU4LjE4OCIsIm5hbWUiOiJPaWhhbmEgRWxpemFnb3llbiBVZ2FsZGUiLCJvaWQiOiIxZTNlZjljNC02ODYwLTRmZDMtYWNhNi03MzVmMDYxMjgxNjUiLCJwbGF0ZiI6IjUiLCJwdWlkIjoiMTAwMzIwMDFGMzNFQjU3NSIsInJoIjoiMC5BWUlBaHJZUXF5UmlJa2VneExmbW51WWFSZ01BQUFBQUFBQUF3QUFBQUFBQUFBQ1ZBRnMuIiwic2NwIjoiQm9va2luZ3MuTWFuYWdlLkFsbCBCb29raW5ncy5SZWFkLkFsbCBCb29raW5ncy5SZWFkV3JpdGUuQWxsIEJvb2tpbmdzQXBwb2ludG1lbnQuUmVhZFdyaXRlLkFsbCBEaXJlY3RvcnkuUmVhZC5BbGwgRGlyZWN0b3J5LlJlYWRXcml0ZS5BbGwgb3BlbmlkIHByb2ZpbGUgVXNlci5SZWFkIFVzZXIuUmVhZC5BbGwgVXNlci5SZWFkQmFzaWMuQWxsIFVzZXIuUmVhZFdyaXRlIFVzZXIuUmVhZFdyaXRlLkFsbCBlbWFpbCIsInN1YiI6IjBqWUc2NzJabExCNG5zT0JORzcyVkR5Y01zSENldlhfWVA4Q2xqaVBiV3MiLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiRVUiLCJ0aWQiOiJhYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYiLCJ1bmlxdWVfbmFtZSI6Im9paGFuYWVsaXphZ295ZW5AdXBuYXNpdy5vbm1pY3Jvc29mdC5jb20iLCJ1cG4iOiJvaWhhbmFlbGl6YWdveWVuQHVwbmFzaXcub25taWNyb3NvZnQuY29tIiwidXRpIjoiUVU3R3VuTXFJME9sZnRkRi1NZ2FBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiNjJlOTAzOTQtNjlmNS00MjM3LTkxOTAtMDEyMTc3MTQ1ZTEwIiwiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiJFenMyRFdDQUJmQWp5dm11ek9RMXN2NmNDemd2NUpQVmdwN1p0S0FoeGt3In0sInhtc190Y2R0IjoxNjUwODgxMzgzfQ.HZ5BEgxLIeTvTlrXtf6cKRaPTo1bO1Odj_-qmgC9ZrX0Vd9i3rUtHhPrylotKWaiycc3Xa-d3iudWS8K7-Tk1GWqElQ6Allw7dB4J9FE6Sqq6v4G-EKOO6K1lgGTPQGC3xLjbGpq0cKL65dwcRz6IOHDPw8DWf9oa2YowdIyc1acLTpk8I8PKKaESASpb_xtWKmnlhg0puyj-ucjKAtFpu4o3esXTL7qmiOnmgjeQyAnD28NB4zpouMHXEzui9X_LFtGOsixaOm7ZGb9iE3A_z5VBXgfnCvmSxJCH2vuoLSNbhyCDAF5NyH1BMVFnfpzS3TdQMFtTELBgMb8ipSp0Q");
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
    public function deleteGenerate($url){
        return $this->init()
            ->setURL($url)
            ->setCustomRequest("DELETE")
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