<?php

namespace Omnipay\Repay\Message\Hosted;

/**
 * REPAY Purchase Request
 */
class AuthorizeRequest extends AbstractRequest
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
            'transaction_type' => "auth",
            'save_payment_method' => $this->getSavePaymentMethod(),
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
     * @param bool $value
     */
    public function setSavePaymentMethod(bool $value)
    {
        $this->setParameter('savePaymentMethod', $value);
    }

    /**
     * @return mixed
     */
    public function getSavePaymentMethod()
    {
        $value = $this->getParameter('savePaymentMethod');
        return $value ? "true" : "false";
    }

}
