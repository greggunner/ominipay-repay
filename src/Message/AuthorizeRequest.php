<?php

namespace Omnipay\Repay\Message;

class AuthorizeRequest extends AbstractCardRequest
{
    /**
     * @return string
     */
    public function getUri()
    {
        return '/rgapi/v1.0/transactions/card/auth';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Repay\Message\AuthResponse';
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount');

        $card = $this->getCard();
        $card->validate();

        $data = [
            "amount" => $this->getAmount(),
            "name_on_card" => $card->getName(),
            "card_number" => $card->getNumber(),
            "exp_date" => $card->getExpiryDate('my'),
            "cvv" => $card->getCvv(),
            "invoice_id" => $this->getInvoiceId(),
            "custom_fields" => $this->getCustomFields(),
            "customer_id" => $this->getCustomerId(),
            "transaction_id" => $this->getTransactionId(),
            "street" => $card->getBillingAddress1(),
            "zip" => $card->getPostcode()
        ];

        return $data;
    }

}
