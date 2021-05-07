<?php

namespace Omnipay\Repay\Message\Hosted;

/**
 * REPAY Purchase Request
 */
class CheckoutRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getUri()
    {
        return '/checkout/merchant/api/v1/checkout';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return CheckoutResponse::class;
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('paymentMethod');
        return [
            'payment_method' => $this->getPaymentMethod()
        ];
    }

}
