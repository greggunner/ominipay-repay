<?php

namespace Omnipay\Repay\Message;

use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * REPAY Purchase Request
 */
class Response extends AbstractResponse
{
    /**
     * @var HttpResponse  HTTP response object
     */
    public $response;

    /**
     * @var string  Payment status that determines success
     */
    protected $resultOk = '0';

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
        if ($code !== 200) {
            return false;
        }

        if (isset($this->data['result']) && $this->data['result'] == $this->resultOk) {
            return true;
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (isset($this->data['result_text'])) {
            return $this->data['result_text'];
        }
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        if (isset($this->data['result'])) {
            return $this->data['result'];
        }
    }

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
