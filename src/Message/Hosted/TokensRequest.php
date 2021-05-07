<?php

namespace Omnipay\Repay\Message\Hosted;

class TokensRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getUri()
    {
        return '/checkout/merchant/api/v1/customers/'.$this->getCustomerId().'/vault-tokens';
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return TokensResponse::class;
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('customerId');
        return [];
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
