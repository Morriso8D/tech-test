<?php

namespace App\Services\CopyAndPay;

use Illuminate\Support\Facades\Log;

class PaymentStatus
{

    private $endpoint;
    private $secret;
    private $entityId;

    public function __construct()
    {
        $this->baseUrl = config('services.copy_and_pay.base_url');
        $this->secret = config('services.copy_and_pay.secret');
        $this->entityId = config('services.copy_and_pay.entity_id');
    }

    public function send($data)
    {
        $endpoint = $this->buildEndpoint($data);
        return $this->post($endpoint);
    }

    private function buildEndpoint($data)
    {
        return "{$this->baseUrl}{$data->resourcePath}?entityId={$this->entityId}";
    }

    private function post($endpoint)
    {
        try {
            
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization:Bearer {$this->secret}"]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $responseData = curl_exec($ch);
            
            if(curl_errno($ch)) {
                return curl_error($ch);
            }

            curl_close($ch);

            if(($responseJson = json_decode($responseData)) === null){

                throw new \Exception('Failed to decode response');
            }

            if(!isset($responseJson->id)){

                throw new \Exception($responseData);
            }

            return $responseJson;

        } catch (\Exception $err) {
            
            Log::error("CopyAndPay\PaymentStatus.php failed to send. Error: {$err}\n\n endpoint: {$endpoint}");
        }
    }
}