<?php

namespace Omnipay\Repay\Message;

class AuthorizeTokenRequest extends AuthorizeRequest
{
    /**
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
