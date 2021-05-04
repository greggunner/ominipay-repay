<?php
namespace Omnipay\Repay\Message;


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
        return 'https://' . $this->getParameter('apiHostname') . $this->getUri();
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
                'rg-api-user: ' . $this->getUsername(),
                'rg-api-secure-token: ' . $this->getSecureToken()
            ],
            json_encode($data)
        );
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Repay\Message\Response';
    }

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

    public function getApiHostname()
    {
        return $this->getParameter('apiHostname');
    }

    public function setApiHostname($value)
    {
        return $this->setParameter('apiHostname', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getSecureToken()
    {
        return $this->getParameter('secureToken');
    }

    public function setSecureToken($value)
    {
        return $this->setParameter('secureToken', $value);
    }

}
