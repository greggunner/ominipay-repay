<?php

namespace Omnipay\Tests\Message;

use Omnipay\Repay\GatewayHosted;
use Omnipay\Repay\Message\Hosted\CheckoutResponse;
use Omnipay\Tests\TestCase;

class HostedCheckoutRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new GatewayHosted($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('https://okinus.sandbox.repay.io');
        $this->gateway->setSecuretoken('securetoken');

        $this->request = $this->gateway->checkout(array(
            'paymentMethod' => 'card'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('card', $data['payment_method']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('HostedCheckoutResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('7960f328-1dd2-4686-b06a-70647f86662a', $response->getCheckoutFormId());
        $this->assertSame(CheckoutResponse::class, $this->request->getResponseClassName());
        $this->assertSame(CheckoutResponse::class, get_class($response));
    }

}
