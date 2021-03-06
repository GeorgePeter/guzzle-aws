<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\SimpleDb\Command;

use Guzzle\Common\Collection;

/**
 * Add attributes to an Amazon SimpleDB item or create an item
 *
 * @link http://docs.amazonwebservices.com/AmazonSimpleDB/latest/DeveloperGuide/index.html?SDB_API_GetAttributes.html
 * @author Michael Dowling <michael@guzzlephp.org>
 *
 * @guzzle domain required="true"
 * @guzzle item_name required="true"
 */
class PutAttributes extends AbstractAttributeCommand
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'PutAttributes';

    /**
     * {@inheritdoc}
     */
    protected function build()
    {
        parent::build();
      $params = $this->filter(function ($key, $value) {
        return $key != 'headers' && preg_match('/Expected\.[0-9]+.*/', $key);
      });
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }
    }

    /**
     * Add an attribute to the command
     *
     * @param string $name The attribute name to set
     * @param string $value The value to set on the attribute
     * @param bool $replace (optional) Set to TRUE to replace any existing
     *      attributes on Amazon SimpleDB
     *
     * @return PutAttributes
     */
    public function addAttribute($name, $value, $replace = false)
    {
      $params = $this->filter(function ($key, $value) {
      return $key != 'headers' && preg_match('/^Attribute(Name)*\.[0-9]+\.Name$/', $key);
    });
        $count = (int) count($params);
        $this->set("Attribute.{$count}.Name", (string) $name);
        $this->set("Attribute.{$count}.Value", (string) $value);
        $this->set("Attribute.{$count}.Replace", ($replace) ? 'true' : 'false');
        
        return $this;
    }

    /**
     * Add an expected condition to the command
     *
     * @param string $name The attribute name to check
     * @param string $value The value to check on the attribute
     * @param bool $replace (optional) Set to TRUE to test the existence of an attribute
     *
     * @return PutAttributes
     */
    public function addExpected($name, $value, $exists = false)
    {
      $params = $this->filter(function ($key, $value) {
      return $key != 'headers' && preg_match('/^Expected\.[0-9]+\.Name$/', $key);
    });
        $count = (int) count($params);
        $this->set("Expected.{$count}.Name", (string) $name);
        $this->set("Expected.{$count}.Value", (string) $value);
        $this->set("Expected.{$count}.Exists", ($exists) ? 'true' : 'false');
        
        return $this;
    }

    /**
     * Set the attributes you want to utilize.
     *
     * @param array $attributes Associative array of attribute names and values
     * @param bool $replace (optional) Set to TRUE to replace existing attributes
     *
     * @return PutAttributes
     */
    public function setAttributes(array $attributes, $replace = false)
    {
        // Remove all previously set attributes
        foreach ($this->getAll('/^Attribute\.[0-9]+\..*/', Collection::MATCH_REGEX) as $key => $value) {
            $this->remove($key);
        }

        $count = 0;
        foreach ($attributes as $name => $values) {
            foreach ((array) $values as $value) {
                $this->set("Attribute.{$count}.Name", (string) $name);
                $this->set("Attribute.{$count}.Value", (string) $value);
                if ($replace) {
                    $this->set("Attribute.{$count}.Replace", 'true');
                }
                $count++;
            }
        }
        
        return $this;
    }
}