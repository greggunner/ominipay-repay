<?php

namespace Omnipay\Repay\Message;

/**
 * REPAY Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getUri()
    {
        return '/rgapi/v1.0/transactions/card/sale';
    }

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
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $card = $this->getCard();

        $data = [
            'amount' => $this->getAmount(),
            'card_number' => $card->getNumber(),
            'exp_date' => $card->getExpiryDate('my'),
            'cvv' => $card->getCvv(),
//            'cvv_mode' => '',
//            'magnetic_stripe_data' => '',
            'name_on_card' => $card->getName(),
            'street' => $card->getBillingAddress1(),
            'zip' => $card->getPostcode(),
            'invoice_id' => $this->getInvoiceId(),
//            'customer_id' => '4561',
//            'register_number' => '',
//            'force_duplicate' => false,
//            'card_not_present' => true,
//            'is_quasi_cash' => true,
//            'convenience_amount' => 4.95,
//            'custom_fields' => [],
        ];

        return $data;
    }

}
