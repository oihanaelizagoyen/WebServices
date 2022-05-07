<?php

if(!isset($_COOKIE["graph_token"])) {
    //Se puede poner aquí directamente sin la cookie
    define("TOKEN", "eyJ0eXAiOiJKV1QiLCJub25jZSI6IkNBT28wUFRJcVctb0N1RkFaRng0WEZLTDFPNHJZaWoxT2ZjVk9CdnptNU0iLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hYjEwYjY4Ni02MjI0LTQ3MjItYTBjNC1iN2U2OWVlNjFhNDYvIiwiaWF0IjoxNjUxOTExMjY4LCJuYmYiOjE2NTE5MTEyNjgsImV4cCI6MTY1MTkxNTQwMCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZRGhsWEIxWXFGcDFTNEJSKyt3bnpRblIxNE0rYVJySmZMazQ2VzdiOU0rVG1uVUIiLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6IkVsaXphZ295ZW4gVWdhbGRlIiwiZ2l2ZW5fbmFtZSI6Ik9paGFuYSIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjQ2LjI1LjE4OC4yNTQiLCJuYW1lIjoiT2loYW5hIEVsaXphZ295ZW4gVWdhbGRlIiwib2lkIjoiMWUzZWY5YzQtNjg2MC00ZmQzLWFjYTYtNzM1ZjA2MTI4MTY1IiwicGxhdGYiOiI1IiwicHVpZCI6IjEwMDMyMDAxRjMzRUI1NzUiLCJyaCI6IjAuQVlJQWhyWVFxeVJpSWtlZ3hMZm1udVlhUmdNQUFBQUFBQUFBd0FBQUFBQUFBQUNWQUZzLiIsInNjcCI6IkJvb2tpbmdzLk1hbmFnZS5BbGwgQm9va2luZ3MuUmVhZC5BbGwgQm9va2luZ3MuUmVhZFdyaXRlLkFsbCBCb29raW5nc0FwcG9pbnRtZW50LlJlYWRXcml0ZS5BbGwgRGlyZWN0b3J5LlJlYWQuQWxsIERpcmVjdG9yeS5SZWFkV3JpdGUuQWxsIG9wZW5pZCBwcm9maWxlIFVzZXIuUmVhZCBVc2VyLlJlYWQuQWxsIFVzZXIuUmVhZEJhc2ljLkFsbCBVc2VyLlJlYWRXcml0ZSBVc2VyLlJlYWRXcml0ZS5BbGwgZW1haWwiLCJzdWIiOiIwallHNjcyWmxMQjRuc09CTkc3MlZEeWNNc0hDZXZYX1lQOENsamlQYldzIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiYWIxMGI2ODYtNjIyNC00NzIyLWEwYzQtYjdlNjllZTYxYTQ2IiwidW5pcXVlX25hbWUiOiJvaWhhbmFlbGl6YWdveWVuQHVwbmFzaXcub25taWNyb3NvZnQuY29tIiwidXBuIjoib2loYW5hZWxpemFnb3llbkB1cG5hc2l3Lm9ubWljcm9zb2Z0LmNvbSIsInV0aSI6IjE2X3dvRFAzQlU2UHZtRGlVN280QUEiLCJ2ZXIiOiIxLjAiLCJ3aWRzIjpbIjYyZTkwMzk0LTY5ZjUtNDIzNy05MTkwLTAxMjE3NzE0NWUxMCIsImI3OWZiZjRkLTNlZjktNDY4OS04MTQzLTc2YjE5NGU4NTUwOSJdLCJ4bXNfc3QiOnsic3ViIjoiRXpzMkRXQ0FCZkFqeXZtdXpPUTFzdjZjQ3pndjVKUFZncDdadEtBaHhrdyJ9LCJ4bXNfdGNkdCI6MTY1MDg4MTM4M30.bxpEHcJjpxcvKiZHAh5ipWnal-aThqv1_8uBBp4jrhbvUo-tQGgUAWuGWvGyga1xBgrVJWAw9ka839thxWTuZoRDnCegFq7joDgPP-hRa_gvwlGJg0PUkTIg88jBA372uLb2x1HFgMMPWVlNHkUf13Ty0khLrQ4CSSuk4MHjUctjZ8jYRGtfuM8nzrh3Yrll9OrQwLD5c-gTFjRz6D_8s1zEdsEqr-zSucLRODfkm2gzzBrTcR1zyDsjOyo3972gC5tjZh7czEfVHeSRQ-Lfp8VETMPIyTla4FgW6WDBjtNe-x_lHI0SnKFR3SfbaXVh54m0_D9nu6DDndYxgFiogw");
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