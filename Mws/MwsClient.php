<?php

namespace Guzzle\Service\Aws\Mws;

use Guzzle\Service\Client;
use Guzzle\Common\Inflector;

/**
 * Client for Amazon Marketplace Web Service
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @see https://developer.amazonservices.com/
 *
 * @guzzle cache.key_filter static="query=Timestamp, Signature"
 * @guzzle merchant_id required="true" doc="AWS Merchant ID"
 * @guzzle marketplace_id required="true" doc="AWS Marketplace ID"
 * @guzzle access_key_id required="true" doc="AWS Access Key ID"
 * @guzzle secret_access_key required="true" doc="AWS Secret Access Key"
 * @guzzle application_name required="true" doc="Application name"
 * @guzzle application_version required="true" doc="Application version"
 * @guzzle base_url required="true" default="{{ protocol }}://{{ region }}/" doc="SQS service base URL"
 * @codeCoverageIgnore
 */
class MwsClient extends Client
{
    /**
     * Get feed class
     * 
     * @param string $feedType The type of feed ot retrieve
     *
     * @return \Guzzle\Service\Aws\Mws\Model\Feed\AbstractFeed
     */
    public function getFeed($feedType)
    {
        $class = 'Guzzle\\Service\\Aws\\Mws\\Model\\Feed\\' 
            . ucfirst(Inflector::camel($feedType));

        return new $class($this);
    }
}