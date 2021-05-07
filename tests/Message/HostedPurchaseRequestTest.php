<?php

namespace Omnipay\Tests\Message;

use Omnipay\Repay\HostedGateway;
use Omnipay\Repay\Message\Hosted\RedirectResponse;
use Omnipay\Tests\TestCase;

class HostedPurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('https://okinus.sandbox.repay.io');
        $this->gateway->setSecuretoken('');

        $this->request = $this->gateway->purchase(array(
            'amount' => '5.00',
            'customerId' => '1234'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('5.00', $data['amount']);
        $this->assertSame('1234', $data['customer_id']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('HostedPurchaseResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('https://providedsubdomain.repay.io/checkout/#/checkout-form/922e53d0-e6b0-4fbc-b2ec-9ee9d4f0c4e2/eyJhbW91bnQiOiAiMS4zMCIsICJjdXN0b21lcl9pZCI6ICJjdXN0MTIzNDU2IiwgInBheXRva2VuIjogIjBGbmhYOHRCNXlpd3NUdUd5RWxNTE1ENGM1eEhkRWFMcGNpVldQR0loV1dHdmh6Y01uLkVLVUhLdy5IZnFIbEh1a083cE5tOWFZSTBLQ1AzRi1XWTQifQ==', $response->getRedirectUrl());
        $this->assertSame(RedirectResponse::class, $this->request->getResponseClassName());
        $this->assertSame(RedirectResponse::class, get_class($response));
    }
}
