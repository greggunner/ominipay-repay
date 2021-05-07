<?php

namespace Omnipay\Repay\Message\Hosted;

class TokenSaleRequest extends AbstractRequest
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
        $this->validate('amount', 'customerId', 'numberLastFour', 'brand');

        return [
            'amount' => $this->getAmount(),
            'customer_id' => $this->getCustomerId(),
            'transaction_type' => 'sale',
            'card_last_four' => $this->getNumberLastFour(),
            'card_brand' => $this->getBrand(),
            'card_token' => $this->getToken()
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

    /**
     * @param $value
     */
    public function setNumberLastFour($value)
    {
        $this->setParameter('numberLastFour', $value);
    }

    /**
     * @return mixed
     */
    public function getNumberLastFour()
    {
        return $this->getParameter('numberLastFour');
    }

    /**
     * @param $value
     */
    public function setBrand($value)
    {
        $this->setParameter('brand', $value);
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->getParameter('brand');
    }

}
