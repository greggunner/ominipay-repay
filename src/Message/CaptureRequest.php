<?php

namespace Omnipay\Repay\Message;

/**
 * REPAY Purchase Request
 */
class CaptureRequest extends AbstractCardRequest
{

    /**
     * @return string
     */
    public function getUri()
    {
        return '/rgapi/v1.0/transactions/card/' . $this->getTransactionReference() . '/capture';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Repay\Message\CaptureResponse';
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount');

        $data = [
            "amount" => $this->getAmount(),
            "invoice_id" => $this->getInvoiceId(),
            "customer_id" => $this->getCustomerId(),
            "custom_fields" => $this->getCustomFields(),
            "transaction_id" => $this->getTransactionId(),
        ];

        return $data;
    }

}
