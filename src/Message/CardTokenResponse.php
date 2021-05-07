<?php

namespace Omnipay\Repay\Message;

use Omnipay\Common\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * REPAY Purchase Request
 */
class CardTokenResponse extends Response
{

    /**
     * @var HttpResponse  HTTP response object
     */
    public $response;

    /**
     * Constructor
     *
     * @param RequestInterface $request   The initiating request
     * @param ResponseInterface     $response  HTTP response object
     */
    public function __construct(RequestInterface $request, $response)
    {
        $this->response = $response;
        parent::__construct($request, json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Is the response successful?
     *
     * Based on HTTP status code, as some requests have an empty body (no data) but are still a success.
     * For example see tests/Mock/JsonRefundResponseSuccess.txt
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $code = $this->response->getStatusCode();
        if ($code == 200) {
            return true;
        }
        return false;
    }


    /**
     * @return string|null
     */
    public function getCardTokenKey()
    {
        if (isset($this->data['card_token_key'])) {
            return $this->data['card_token_key'];
        }
    }

    /**
     * @return string|null
     */
    public function getLastFour()
    {
        if (isset($this->data['last4'])) {
            return $this->data['last4'];
        }
    }

    /**
     * @return string|null
     */
    public function getIsEligibleForDisbursement()
    {
        if (isset($this->data['is_eligible_for_disbursement'])) {
            return $this->data['is_eligible_for_disbursement'];
        }
    }

}
