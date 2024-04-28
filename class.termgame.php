<?php
class TermgameSeller
{
    private $apiKey;
    private $api_endpoint = "https://api.termgameseller.com";

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function request($method = "GET", $path, $data = [])
    {
        $curl = curl_init();

        if ($method == "GET") {
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->api_endpoint . $path,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'x-api-key: ' . $this->apiKey
                    ),
                )
            );
        } else {
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->api_endpoint . $path,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array(
                        'x-api-key: ' . $this->apiKey,
                        'Content-Type: application/json'
                    ),
                )
            );
        }

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function getBalance()
    {
        return $this->request("GET", "/v1/api/balance");
    }
    public function games()
    {
        return $this->request("GET", "/v1/api/games");
    }
    public function servers()
    {
        return $this->request("GET", "/v1/api/servers");
    }
    public function packages()
    {
        return $this->request("GET", "/v1/api/packages");
    }
    public function transactions()
    {
        return $this->request("GET", "/v1/api/transaction");
    }

    public function buy($data = [])
    {
        return $this->request("POST", "/v1/api/enqueue", $data);
    }
}
?>
