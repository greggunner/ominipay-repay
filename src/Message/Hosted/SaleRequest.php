<?php

namespace Omnipay\Repay\Message\Hosted;

/**
 * REPAY Purchase Request
 */
class SaleRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getUri()
    {
        return '/checkout/merchant/api/v1/checkout-forms/'.$this->getCheckoutFormId().'/one-time-use-url';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return RedirectResponse::class;
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount', 'customerId');
        return [
            'amount' => $this->getAmount(),
            'customer_id' => $this->getCustomerId(),
            'transaction_type' => 'sale',
        ];
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

}
