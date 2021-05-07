<?php

namespace Omnipay\Repay\Message;

/**
 * REPAY Purchase Request
 */
class UpdateCardTokenRequest extends AbstractCardTokenRequest
{

    /**
     * @return string
     */
    public function getUri()
    {
        return '/rgapi/v1.0/customers/' . $this->getCustomerKey() . '/cardtokens/' . $this->getToken();
    }

}
