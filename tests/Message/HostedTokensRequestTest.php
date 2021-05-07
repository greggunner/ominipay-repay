<?php

namespace Omnipay\Tests\Message;

use Omnipay\Repay\GatewayHosted;
use Omnipay\Repay\Message\Hosted\TokensResponse;
use Omnipay\Tests\TestCase;

class HostedTokensRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new GatewayHosted($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('https://okinus.sandbox.repay.io');
        $this->gateway->setSecuretoken('');

        $this->request = $this->gateway->tokens(array(
            'customerId' => '1234'
        ));
    }

    public function testGetData()
    {
        $this->assertSame('1234', $this->request->getCustomerId());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('HostedTokensResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $tokens = $response->getTokens();
        $this->assertCount(1, $tokens);
        $this->assertSame('76204d4b-bdab-4187-b371-7dd28fd9c5ee', $tokens[0]['id']);
        $this->assertSame('550826661', $tokens[0]['token']);
        $this->assertSame('card_token', $tokens[0]['payment_method']);
        $this->assertSame(TokensResponse::class, $this->request->getResponseClassName());
        $this->assertSame(TokensResponse::class, get_class($response));
    }
}
