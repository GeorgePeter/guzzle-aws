<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\SimpleDb\Command;

use Guzzle\Common\Collection;

/**
 * Delete attributes from an Amazon SimpleDB item
 *
 * @link http://docs.amazonwebservices.com/AmazonSimpleDB/latest/DeveloperGuide/index.html?SDB_API_GetAttributes.html
 * @author Michael Dowling <michael@guzzlephp.org>
 *
 * @guzzle domain required="true"
 * @guzzle item_name required="true"
 */
class DeleteAttributes extends AbstractAttributeCommand
{
  /**
   * {@inheritdoc}
   */
  protected $action = 'DeleteAttributes';

  /**
   * {@inheritdoc}
   */
  protected function build()
  {
    parent::build();
    $params = $this->filter(function ($key, $value) {
      return $key != 'headers' && preg_match('/^Expected\.[0-9]+\.(Name|Value|Exists)$/', $key);
    });
    foreach ($params as $key => $value) {
      $this->request->getQuery()->set($key, $value);
    }
  }

  /**
   * Add an expected condition to the command
   *
   * @param string $name The attribute name to check
   * @param string $value The value to check on the attribute
   * @param bool $replace (optional) Set to TRUE to test the existence of an
   *      attribute
   *
   * @return DeleteAttributes
   */
  public function addExpected($name, $value, $exists = false)
  {
    $params = $this->filter(function ($key, $value) {
      return $key != 'headers' && preg_match('/^Expected\.[0-9]+\.(Name|Value|Exists)$/', $key);
    });
    $count = (int)count($params);
    $this->set("Expected.{$count}.Name", (string)$name);
    $this->set("Expected.{$count}.Value", (string)$value);
    $this->set("Expected.{$count}.Exists", ($exists) ? 'true' : 'false');

    return $this;
  }
}