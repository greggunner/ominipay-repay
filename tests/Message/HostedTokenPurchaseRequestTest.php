<?php

namespace Omnipay\Tests\Message;

use Omnipay\Repay\HostedGateway;
use Omnipay\Repay\Message\Hosted\RedirectResponse;
use Omnipay\Tests\TestCase;

class HostedTokenPurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('https://okinus.sandbox.repay.io');
        $this->gateway->setSecuretoken('');

        $this->request = $this->gateway->tokenPurchase(array(
            'amount' => '5.00',
            'customerId' => '1234',
            'numberLastFour' => '6789',
            'brand' => 'VISA',
            'token' => '550826661'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('5.00', $data['amount']);
        $this->assertSame('1234', $data['customer_id']);
        $this->assertSame('sale', $data['transaction_type']);
        $this->assertSame('6789', $data['card_last_four']);
        $this->assertSame('VISA', $data['card_brand']);
        $this->assertSame('550826661', $data['card_token']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('HostedTokenPurchaseResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('https://providedsubdomain.repay.io/checkout/#/checkout-form/a27707ef-15a8-4995-b3a5-670cf43ede32/eyJjYXJkX2xhc3RfZm91ciI6ICI5OTA0IiwgImNhcmRfYnJhbmQiOiAiVklTQSIsICJhbW91bnQiOiAiMTAwLjAwIiwgImNhcmRfdG9rZW4iOiAiNTUwODI2NjYxIiwgImN1c3RvbWVyX2lkIjogIkpvaG4gU21pdGgiLCAidHJhbnNhY3Rpb25fdHlwZSI6ICJzYWxlIiwgInBheXRva2VuIjogIm5ZVnlmVVJYT01DWjdxOVNPNE1fX0dYZVBDcVRnZFhZSGpqTnV2SmEyamFhZzNaWEQ4LkVLVVF6Zy43anZwa19VTDBIS3JBaGl1b203blhTR3JMN1EifQ==', $response->getRedirectUrl());
        $this->assertSame(RedirectResponse::class, $this->request->getResponseClassName());
        $this->assertSame(RedirectResponse::class, get_class($response));
    }
}
