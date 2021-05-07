<?php

namespace Omnipay\Repay\Message;

/**
 * REPAY Purchase Request
 */
class ReversalRequest extends AbstractCardRequest
{

    /**
     * @return string
     */
    public function getUri()
    {
        return '/rgapi/v1.0/transactions/card/' . $this->getTransactionReference() . '/reversal';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Repay\Message\ReversalResponse';
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $data = [
            "invoice_id" => $this->getInvoiceId(),
            "customer_id" => $this->getCustomerId(),
            "custom_fields" => $this->getCustomFields(),
            "transaction_id" => $this->getTransactionId(),
        ];

        return $data;
    }

}
