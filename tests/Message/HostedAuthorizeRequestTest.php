<?php

namespace Omnipay\Tests\Message;

use Omnipay\Repay\GatewayHosted;
use Omnipay\Repay\Message\Hosted\RedirectResponse;
use Omnipay\Tests\TestCase;

class HostedAuthorizeRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new GatewayHosted($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('https://okinus.sandbox.repay.io');
        $this->gateway->setSecuretoken('');

        $this->request = $this->gateway->authorize(array(
            'amount' => '5.00',
            'customerId' => '1234',
            'savePaymentMethod' => true
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('5.00', $data['amount']);
        $this->assertSame('1234', $data['customer_id']);
        $this->assertSame('auth', $data['transaction_type']);
        $this->assertSame('true', $data['save_payment_method']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('HostedAuthorizeResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('https://providedsubdomain.repay.io/checkout/#/checkout-form/922e53d0-e6b0-4fbc-b2ec-9ee9d4f0c4e2/eyJhbW91bnQiOiAiMC4wMCIsICJjdXN0b21lcl9pZCI6ICJjdXN0MTIzNDU2IiwgInRyYW5zYWN0aW9uX3R5cGUiOiAiYXV0aCIsICJwYXl0b2tlbiI6ICIxTi1OckJjblFvMlNOTUhqZnNTdlhoUzlvdzMxRXhkOUtPLTFFYXVPbDVwWWEwc2ZNYi5FS1VLQ0EuWEJnV1ptV0F1ZFQyQ0l0VUEwYVp5eFg2eVZvIn0=', $response->getRedirectUrl());
        $this->assertSame(RedirectResponse::class, $this->request->getResponseClassName());
        $this->assertSame(RedirectResponse::class, get_class($response));
    }
}
