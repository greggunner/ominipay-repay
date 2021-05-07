<?php
namespace Omnipay\Repay\Message\Hosted;


use Omnipay\Repay\Message\Response;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Method required to override for getting the specific request endpoint
     *
     * @return string
     */
    abstract public function getUri();

    /**
     * @return string The end point to call
     */
    public function getEndpoint()
    {
        return 'https://' . $this->getParameter('hostname') . $this->getUri();
    }

    /**
     * The HTTP method used to send data to the API endpoint
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

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
                'Authorization' => 'apptoken ' . $this->getSecuretoken()
            ],
            json_encode($data)
        );
    }

    /**
     * @return string
     */
    abstract public function getResponseClassName();

    /**
     * Send the request to the API then build the response object
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     *
     * @return Response
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);

        $responseClass = $this->getResponseClassName();
        return $this->response = new $responseClass($this, $httpResponse);
    }

    public function getHostname()
    {
        return $this->getParameter('hostname');
    }

    public function setHostname($value)
    {
        return $this->setParameter('hostname', $value);
    }

    public function getSecuretoken()
    {
        return $this->getParameter('securetoken');
    }

    public function setSecuretoken($value)
    {
        return $this->setParameter('securetoken', $value);
    }

    public function setCheckoutFormId($value)
    {
        $this->setParameter('checkoutFormId', $value);
    }

    public function getCheckoutFormId()
    {
        $this->getParameter('checkoutFormId');
    }

}
