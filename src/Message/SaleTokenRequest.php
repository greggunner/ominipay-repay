<?php

namespace Omnipay\Repay\Message;

class SaleTokenRequest extends SaleRequest
{

    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $data = parent::getData();
        $this->validate('cardReference');
        $data["card_token"] = $this->getCardReference();
        return $data;
    }

}
