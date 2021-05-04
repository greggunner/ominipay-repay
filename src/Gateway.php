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
            'apiHostname' => '',
            'username' => '',
            'secureToken' => '',
        );
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Repay\Message\PurchaseRequest', $parameters);
    }

}
