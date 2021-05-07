<?php

namespace Omnipay\Repay;

use Omnipay\Common\AbstractGateway;

/**
 * Repay Gateway
 *
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Repay';
    }

    public function getShortName()
    {
        return 'repay';
    }

    public function getDefaultParameters()
    {
        return array(
            'hostname' => '',
            'username' => '',
            'securetoken' => '',
        );
    }

    public function getHostname()
    {
        return $this->getParameter('hostname');
    }

    public function setHostname($value)
    {
        return $this->setParameter('hostname', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getSecuretoken()
    {
        return $this->getParameter('securetoken');
    }

    public function setSecuretoken($value)
    {
        return $this->setParameter('securetoken', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Repay\Message\SaleRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Repay\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Repay\Message\CaptureRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Repay\Message\RefundRequest', $parameters);
    }

    public function reversal(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Repay\Message\ReversalRequest', $parameters);
    }

    public function checkout(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Repay\Message\CheckoutRequest', $parameters);
    }


}
