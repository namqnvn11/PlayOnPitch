<?php

namespace App\Services;

use GuzzleHttp\Client;

class MomoService
{
    protected $endpoint;
    protected $partnerCode;
    protected $accessKey;
    protected $secretKey;
    protected $extraData;
//    protected $paymentCode;
    protected  $redirectUrl;
    protected  $ipnUrl;
    protected  $requestType;

    public function __construct()
    {
        $this->endpoint = config('payment.momo.endpoint_url');
        $this->partnerCode = config('payment.momo.partner_code');
        $this->accessKey = config('payment.momo.access_key');
        $this->secretKey = config('payment.momo.secret_key');
        $this->extraData = "";
        $this->requestType = "payWithATM";
        $this->redirectUrl = config('payment.momo.redirect_url');
        $this->ipnUrl = config('payment.momo.inp_url');
    }

    public function createPayment($orderId, $amount, $orderInfo, $name,$requestId)
    {
        $client = new Client();
        $rawHash = "accessKey=" . $this->accessKey . "&amount=" . $amount . "&extraData=" . $this->extraData . "&ipnUrl=" . $this->ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $this->partnerCode . "&redirectUrl=" . $this->redirectUrl . "&requestId=" . $requestId . "&requestType=" . $this->requestType;
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);
        $data = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => 'test',
            'storeId' => 'MomoTestStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            "ipnUrl" => $this->ipnUrl,
            'redirectUrl' => $this->redirectUrl,
            'lang' => 'vi',
            "extraData" => $this->extraData,
            'requestType' => $this->requestType,
            'signature' => $signature,
        ];
        $response = $client->post($this->endpoint, [
            'json' => $data
        ]);

        return json_decode($response->getBody(), true);
    }
}
