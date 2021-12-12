<?php

namespace App\Services\CopyAndPay;
use Illuminate\Support\Facades\Log;

class InitCheckout
{

    private $endpoint;
    private $secret;
    private $entityId;

    public function __construct()
    {
        $this->endpoint = config('services.copy_and_pay.endpoint');
        $this->secret = config('services.copy_and_pay.secret');
        $this->entityId = config('services.copy_and_pay.entity_id');
    }

    public function send($data)
    {
        $payload = $this->buildPayload($data);
        return $this->post($payload);
    }

    private function buildPayload($data)
    {
        return "entityId={$this->entityId}&amount={$data->amount}&currency={$data->currency}&merchantTransactionId={$data->reference}&paymentType=DB";
    }

    private function post($payload)
    {
     
        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->endpoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization:Bearer {$this->secret}"]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $responseData = curl_exec($ch);

            if(curl_errno($ch)) {

                throw new \Exception($ch);
                
            }

            curl_close($ch);

            if(($responseJson = json_decode($responseData)) === null){

                throw new \Exception('Failed to decode response');

            }

            if(!isset($responseJson->id)){

                throw new \Exception($responseData);

            }

            return $responseJson->id;
            
        } catch (\Exception $err) {
            
            Log::error("CopyAndPay\InitCheckout.php failed to send. Error: {$err}");

        }
    }
}