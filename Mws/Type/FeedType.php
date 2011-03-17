<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Mws\Type;

/**
 * Feed types
 * 
 * @author Harold Asbridge <harold@shoebacca.com>
 * @codeCoverageIgnore
 */
class FeedType
{
    const PRODUCT_FEED = '_POST_PRODUCT_DATA_';
    const RELATIONSHIPS_FEED = '_POST_PRODUCT_RELATIONSHIP_DATA_';
    const SINGLE_FORMAT_ITEM_FEED = '_POST_ITEM_DATA_';
    const SHIPPING_OVERRIDE_FEED = '_POST_PRODUCT_OVERRIDES_DATA_';
    const PRODUCT_IMAGES_FEED = '_POST_PRODUCT_IMAGE_DATA_';
    const PRICING_FEED = '_POST_PRODUCT_PRICING_DATA_';
    const INVENTORY_FEED = '_POST_INVENTORY_AVAILABILITY_DATA_';
    const ORDER_ACKNOWLEDGEMENT_FEED = '_POST_ORDER_ACKNOWLEDGEMENT_DATA_';
    const ORDER_FULFILLMENT_FEED = '_POST_ORDER_FULFILLMENT_DATA_';
    const FBA_SHIPMENT_INJECTION_FULFILLMENT_FEED = '_POST_FULFILLMENT_ORDER_REQUEST_DATA_';
    const FBA_SHIPMENT_INJECTION_CANCELLATION_FEED = '_POST_FULFILLMENT_ORDER_CANCELLATION_REQUEST_DATA_';
    const ORDER_ADJUSTMENT_FEED = '_POST_PAYMENT_ADJUSTMENT_DATA_';
    const FLATFILE_LISTINGS_FEED = '_POST_FLAT_FILE_LISTINGS_DATA_';
    const FLATFILE_ORDER_ACKNOWLEDGEMENT_FEED = '_POST_FLAT_FILE_ORDER_ACKNOWLEDGEMENT_DATA_';
    const FLATFILE_ORDER_FULFILLMENT_FEED = '_POST_FLAT_FILE_FULFILLMENT_DATA_';
    const FLATFILE_ORDER_ADJUSTMENT_FEED = '_POST_FLAT_FILE_PAYMENT_ADJUSTMENT_DATA_';
    const FLATFILE_INVENTORY_LOADER_FEED = '_POST_FLAT_FILE_INVLOADER_DATA_';
    const FLATFILE_MUSIC_LOADER_FILE = '_POST_FLAT_FILE_CONVERGENCE_LISTINGS_DATA_';
    const FLATFILE_BOOK_LOADER_FILE = '_POST_FLAT_FILE_BOOKLOADER_DATA_';
    const FLATFILE_PRICE_AND_QUANTITY_UPDATE_FILE = '_POST_FLAT_FILE_PRICEANDQUANTITYONLY_UPDATE_DATA_';
    const UIEE_INVENTORY_FILE = '_POST_UIEE_BOOKLOADER_DATA_';
}
