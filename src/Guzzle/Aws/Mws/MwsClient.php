<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws;

use \Guzzle\Common\Collection;
use Guzzle\Plugin\Backoff\BackoffPlugin;
use Guzzle\Plugin\Backoff\HttpBackoffStrategy;
use Guzzle\Aws\AbstractClient;
use Guzzle\Aws\QueryStringAuthPlugin;
use Guzzle\Aws\Signature\SignatureV2;

/**
 * Client for Amazon Marketplace Web Service
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @author Michael Dowling <michael@guzzlephp.org>
 * @see https://developer.amazonservices.com/
 */
class MwsClient extends AbstractClient
{
    /**
     * @var string API version
     */
    const VERSION = '2009-01-01';
    
    /**
     * @var array Supported feeds
     */
    protected $feedRegistry = array(
        'image'             => '\Guzzle\Aws\Mws\Model\Feed\ImageFeed',
        'inventory'         => '\Guzzle\Aws\Mws\Model\Feed\InventoryFeed',
        'order_fulfillment' => '\Guzzle\Aws\Mws\Model\Feed\OrderFulfillmentFeed',
        'price'             => '\Guzzle\Aws\Mws\Model\Feed\PriceFeed',
        'product'           => '\Guzzle\Aws\Mws\Model\Feed\ProductFeed',
        'relationship'      => '\Guzzle\Aws\Mws\Model\Feed\RelationshipFeed'
    );

    /**
     * Factory method to create a new MWS client
     *
     * @param array|Collection $config Configuration data. Array keys:
     *    base_url - Base URL of web service.  Default: https://mws.amazonservices.com/
     *    version - API version.  Defaults to 2009-02-01
     *  * access_key - AWS access key ID
     *  * secret_key - AWS secret access key
     *  * merchant_id - AWS merchant ID
     *  * marketplace_id - AWS marketplace ID
     *   application_name - Application name
     *   application_version - Application version
     *
     * @return MwsClient
     */
    public static function factory($config = array())
    {
        $defaults = array(
            'base_url' => 'https://mws.amazonservices.com/',
            'version' => self::VERSION
        );
        $required = array('access_key', 'secret_key', 'merchant_id', 'marketplace_id', 'application_name', 'application_version');
        $config = Collection::fromConfig($config, $defaults, $required);

        // Filter our the Timestamp and Signature query string values from cache
        $config->set('cache.key_filter', 'query=Timestamp, Signature');

        $signature = new SignatureV2($config->get('access_key'), $config->get('secret_key'));
        $client = new self(
            $config->get('base_url'),
            $config->get('access_key'),
            $config->get('secret_key'),
            $config->get('version'),
            $signature
        );
        $client->setConfig($config);

        // Sign the request last
        $client->getEventDispatcher()->addSubscriber(
            new QueryStringAuthPlugin($signature, $config->get('version')),
            -9999
        );

        // Retry 500 and 503 failures, up to 3 times
        $client->getEventDispatcher()->addSubscriber(BackoffPlugin::getExponentialBackoff(3, array_merge(
            HttpBackoffStrategy::getDefaultFailureCodes(), array(429)
        )));

        return $client;
    }

    /**
     * Get feed class
     *
     * @param string $feedType The type of feed ot retrieve
     *
     * @return \Guzzle\Aws\Mws\Model\Feed\AbstractFeed
     */
    public function getFeed($feedType)
    {
        if (!isset($this->feedRegistry[$feedType])) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException('Invalid feed type: ' . $feedType);
            // @codeCoverageIgnoreEnd
        }
        
        $feedClass = $this->feedRegistry[$feedType];
        
        return new $feedClass($this);
    }
}