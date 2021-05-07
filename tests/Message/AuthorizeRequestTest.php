<?php

namespace Omnipay\Tests\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Repay\Gateway;
use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('https://okinus.sandbox.repay.io');
        $this->gateway->setUsername('');
        $this->gateway->setSecuretoken('');

        $this->request = $this->gateway->authorize(array(
            'amount' => '5.00',
            'invoiceId' => '1234',
            'currency' => 'USD'
        ));
        $card = new CreditCard([
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2030',
            'cvv' => '123',
            'name' => "Luke Holder",
            'address1' => '123 Somewhere St',
            'address2' => 'Suburbia',
            'city' => 'Little Town',
            'postcode' => '1234',
            'state' => 'CA',
            'country' => 'US',
            'phone' => '1-234-567-8900'
        ]);
        $this->request->setCard($card);
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('5.00', $data['amount']);
        $this->assertSame('1234', $data['invoice_id']);
        $this->assertSame('Luke Holder', $data['name_on_card']);
        $this->assertSame('4242424242424242', $data['card_number']);
        $this->assertSame('123', $data['cvv']);
        $this->assertSame('0630', $data['exp_date']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CardResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
        $this->assertSame('\Omnipay\Repay\Message\AuthResponse', $this->request->getResponseClassName());
        $this->assertSame('Omnipay\Repay\Message\AuthResponse', get_class($response));
    }

}
