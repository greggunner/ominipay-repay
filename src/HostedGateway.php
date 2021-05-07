<?php

namespace Omnipay\Repay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Repay\Message\Hosted\AuthorizeRequest;
use Omnipay\Repay\Message\Hosted\CheckoutRequest;
use Omnipay\Repay\Message\Hosted\SaleRequest;
use Omnipay\Repay\Message\Hosted\TokenSaleRequest;
use Omnipay\Repay\Message\Hosted\TokensRequest;

/**
 * Repay Gateway
 *
 */
class HostedGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Repay Hosted';
    }

    public function getDefaultParameters()
    {
        return array(
            'hostname' => '',
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

    public function getSecuretoken()
    {
        return $this->getParameter('securetoken');
    }

    public function setSecuretoken($value)
    {
        return $this->setParameter('securetoken', $value);
    }

    public function checkout(array $parameters = array())
    {
        return $this->createRequest(CheckoutRequest::class, $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(SaleRequest::class, $parameters);
    }

    public function tokenPurchase(array $parameters = array())
    {
        return $this->createRequest(TokenSaleRequest::class, $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function tokens(array $parameters = array())
    {
        return $this->createRequest(TokensRequest::class, $parameters);
    }


}
