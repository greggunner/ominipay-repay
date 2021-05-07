<?php

namespace Omnipay\Repay\Message;

/**
 * REPAY Purchase Request
 */
abstract class AbstractCardTokenRequest extends AbstractRequest
{

    /**
     * Make the actual request to REPAY
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     *
     * @return \Psr\Http\Message\ResponseInterface HTTP response object
     */
    public function sendRequest($data)
    {
        return $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Content-Type' => 'application/json',
                'rg-api-user: ' . $this->getUsername(),
                'rg-api-secure-token: ' . $this->getSecuretoken(),
                'rg-merchant-id: ' . $this->getMerchantId()
            ],
            json_encode($data)
        );
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Repay\Message\CardTokenResponse';
    }

    /**
     * @param $value
     */
    public function setCustomerKey($value)
    {
        $this->setParameter('customerKey', $value);
    }

    /**
     * @return mixed
     */
    public function getCustomerKey()
    {
        return $this->getParameter('customerKey');
    }

    /**
     * @param $value
     */
    public function setMerchantId($value)
    {
        $this->setParameter('merchantId', $value);
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('customerKey', 'merchantId', 'token');
        $card = $this->getCard();
        $card->validate();

        return [
            'card_number' => $card->getNumber(),
            'exp_date' => $card->getExpiryDate('my'),
            'name_on_card' => $card->getName(),
            'street' => $card->getBillingAddress1(),
            'zip' => $card->getPostcode(),
        ];
    }

}
