<?php

namespace Omnipay\Repay\Message\Hosted;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CheckoutResponse extends AbstractResponse
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

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getCheckoutFormId()
    {
        if (isset($this->data['checkout_form_id'])) {
            return $this->data['checkout_form_id'];
        }
    }

}