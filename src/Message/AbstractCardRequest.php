<?php

namespace Omnipay\Repay\Message;

abstract class AbstractCardRequest extends AbstractRequest
{

    /**
     * @param $value
     */
    public function setInvoiceId($value)
    {
        $this->setParameter('invoiceId', $value);
    }

    /**
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->getParameter('invoiceId');
    }

    /**
     * @param $value
     */
    public function setTransactionId($value)
    {
        $this->setParameter('transactionId', $value);
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    /**
     * @param $value
     */
    public function setOriginalTransactionId($value)
    {
        $this->setParameter('originalTransactionId', $value);
    }

    /**
     * @return mixed
     */
    public function getOriginalTransactionId()
    {
        return $this->getParameter('originalTransactionId');
    }

    /**
     * @param $value
     */
    public function setCustomerId($value)
    {
        $this->setParameter('customerId', $value);
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomFields($value)
    {
        $this->setParameter('customFields', $value);
    }

    public function getCustomFields()
    {
        return $this->getParameter('customFields');
    }

    public function setMerchantId($value)
    {
        $this->setParameter('merchantId', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

}
