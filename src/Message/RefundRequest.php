<?php

namespace Omnipay\Repay\Message;

/**
 * REPAY Purchase Request
 */
class RefundRequest extends AbstractCardRequest
{

    /**
     * @return string
     */
    public function getUri()
    {
        return '/rgapi/v1.0/transactions/card/' . $this->getTransactionReference() . '/refund';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Repay\Message\RefundResponse';
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $data = [
            "amount" => $this->getAmount(),
            "invoice_id" => $this->getInvoiceId()
        ];

        return $data;
    }

}
