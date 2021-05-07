<?php

namespace Omnipay\Repay\Message;

/**
 * REPAY Purchase Request
 */
abstract class AbstractCardResponse extends Response
{

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['transaction_id'])) {
            return $this->data['transaction_id'];
        }
    }

    /**
     * @return string|null
     */
    public function getCardReference()
    {
        if (isset($this->data['card_token'])) {
            return $this->data['card_token'];
        }
    }
}
