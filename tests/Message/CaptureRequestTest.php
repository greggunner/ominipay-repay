<?php

namespace Omnipay\Tests\Message;

use Omnipay\Repay\Gateway;
use Omnipay\Tests\TestCase;

class CaptureRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setHostname('okinus.sandbox.repay.io');
        $this->gateway->setUsername('');
        $this->gateway->setSecuretoken('');

        $this->request = $this->gateway->capture(array(
            'amount' => '5.00',
            'invoiceId' => '1234',
            'transactionId' => '6789'
        ));
        $this->request->setTransactionReference("XYZA123");
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('5.00', $data['amount']);
        $this->assertSame('1234', $data['invoice_id']);
        $this->assertSame('6789', $data['transaction_id']);
    }

    public function testGetEndpoint()
    {
        $this->assertSame('https://okinus.sandbox.repay.io/rgapi/v1.0/transactions/card/XYZA123/capture', $this->request->getEndpoint());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CardResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
        $this->assertSame('\Omnipay\Repay\Message\CaptureResponse', $this->request->getResponseClassName());
        $this->assertSame('Omnipay\Repay\Message\CaptureResponse', get_class($response));
    }

}
