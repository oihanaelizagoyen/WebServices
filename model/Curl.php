<?php

if(!isset($_COOKIE["graph_token"])) {
    //Se puede poner aquí directamente sin la cookie
    define("TOKEN", "eyJ0eXAiOiJKV1QiLCJub25jZSI6Ijl1dXBVV3pmaG9jRHpHRXJRQmVjQlBGYTNyaDV6M1NEeFdZeTVtLTlpSGsiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYvIiwiaWF0IjoxNjUxNDMwMDQyLCJuYmYiOjE2NTE0MzAwNDIsImV4cCI6MTY1MTQzNTY1MSwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZUEE5OFNURFhOcW5YZnUxZndpdjZZcDVncFVlTDFLNWw4bDJwbHBZblRteVppWUEiLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6IkVsaXphZ295ZW4gVWdhbGRlIiwiZ2l2ZW5fbmFtZSI6Ik9paGFuYSIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjEwNC4yOC44OC4xMzIiLCJuYW1lIjoiT2loYW5hIEVsaXphZ295ZW4gVWdhbGRlIiwib2lkIjoiMWUzZWY5YzQtNjg2MC00ZmQzLWFjYTYtNzM1ZjA2MTI4MTY1IiwicGxhdGYiOiI1IiwicHVpZCI6IjEwMDMyMDAxRjMzRUI1NzUiLCJyaCI6IjAuQVlJQWhyWVFxeVJpSWtlZ3hMZm1udVlhUmdNQUFBQUFBQUFBd0FBQUFBQUFBQUNWQUZzLiIsInNjcCI6IkJvb2tpbmdzLk1hbmFnZS5BbGwgQm9va2luZ3MuUmVhZC5BbGwgQm9va2luZ3MuUmVhZFdyaXRlLkFsbCBCb29raW5nc0FwcG9pbnRtZW50LlJlYWRXcml0ZS5BbGwgb3BlbmlkIHByb2ZpbGUgVXNlci5SZWFkIGVtYWlsIiwic3ViIjoiMGpZRzY3MlpsTEI0bnNPQk5HNzJWRHljTXNIQ2V2WF9ZUDhDbGppUGJXcyIsInRlbmFudF9yZWdpb25fc2NvcGUiOiJFVSIsInRpZCI6ImFiMTBiNjg2LTYyMjQtNDcyMi1hMGM0LWI3ZTY5ZWU2MWE0NiIsInVuaXF1ZV9uYW1lIjoib2loYW5hZWxpemFnb3llbkB1cG5hc2l3Lm9ubWljcm9zb2Z0LmNvbSIsInVwbiI6Im9paGFuYWVsaXphZ295ZW5AdXBuYXNpdy5vbm1pY3Jvc29mdC5jb20iLCJ1dGkiOiJhT194YUY5ZUZFMmxOZXBlY1NsOEFBIiwidmVyIjoiMS4wIiwid2lkcyI6WyI2MmU5MDM5NC02OWY1LTQyMzctOTE5MC0wMTIxNzcxNDVlMTAiLCJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX3N0Ijp7InN1YiI6IkV6czJEV0NBQmZBanl2bXV6T1Exc3Y2Y0N6Z3Y1SlBWZ3A3WnRLQWh4a3cifSwieG1zX3RjZHQiOjE2NTA4ODEzODN9.Qj_Ax4I5M4_aqcDv0TgNNboI8ZE8tqHs9LGDRZrkBJQdKcmTYscbGzDFyxFRMgPEP-jBTUOr_Kx8aVQ376xflByNZovnAm22lzNG2YB8LUQ7LJbT15F2-yYEvsPwqoudPZCNh0pou9nqUTIrBYZAvKE7wE6OHG-yakkjRsfmlJd1aXOCc_6k7HySFbb5Ym4cgISy8b_6jWP7GUJTr4gULLsZqap7p3QYQekq8RkucwOIu8QpFzhAbKb23O2SsgjbLyUXAKpbM_49_Nh80lPnN2GvyB6XeZ9UXxfO_LvaHxeFcIL2NsdCv7I4zsjW5BaIBdWK7XkG6mJX_HTuP6Z1EQ");
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