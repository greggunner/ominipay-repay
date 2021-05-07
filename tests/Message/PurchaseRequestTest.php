<?php

namespace Omnipay\Tests\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Repay\Gateway;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('https://okinus.sandbox.repay.io');
        $this->gateway->setUsername('');
        $this->gateway->setSecuretoken('');

        $this->request = $this->gateway->purchase(array(
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
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
        $this->assertSame('\Omnipay\Repay\Message\SaleResponse', $this->request->getResponseClassName());
        $this->assertSame('Omnipay\Repay\Message\SaleResponse', get_class($response));
    }

    /**
     * Simulate card declined (no error in transit, 200 HTTP response)
     */
    public function testSendFailure()
    {
        $this->setMockHttpResponse('PurchaseResponseFailure.txt');
        $response = $this->request->send();

        $data = $this->request->getData();

        $code = $response->response->getStatusCode();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('5.00', $data['amount']);
        $this->assertEquals(200, $code);
        $this->assertEquals("12", $response->getCode());
        $this->assertSame("Declined", $response->getMessage());
        $this->assertSame(667875, $response->getTransactionReference());
    }

    /**
     * Simulate bad request (HTTP 400 or similar)
     */
    public function testSendError()
    {
        $this->setMockHttpResponse('PurchaseResponseError.txt');
        $response = $this->request->send();

        $data = $this->request->getData();

        $code = $response->response->getStatusCode();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('5.00', $data['amount']);
        $this->assertEquals(400, $code);
//        $this->assertSame('BAD_REQUEST', $response->getCode());
//        $this->assertSame("This card is not accepted for Test transactions", $response->getMessage());
        $this->assertNull($response->getTransactionReference());
    }

}
