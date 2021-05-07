<?php

namespace Omnipay\Repay\Message\Hosted;

use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class TokensResponse extends AbstractResponse
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
        return $code == 200;
    }


    public function getTokens()
    {
        if (isset($this->data['vault_tokens'])) {
            return $this->data['vault_tokens'];
        }
        return [];
    }

}
