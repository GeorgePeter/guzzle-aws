<?php

/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Model;

use Guzzle\Http\Client;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\ResourceIterator;

/**
 * Iterator for commands with iterable results
 *
 * Any command which can issue a next token will return an instance
 * of this class as it's result. Iterating over this object with foreach()
 * will automatically get additional pages as needed.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class ResultIterator extends ResourceIterator
{

    public function __construct(CommandInterface $command, array $data = [])
    {
        $this->resources = array_key_exists('resources', $data) ? $data['resources'] : false;
        $this->nextToken = array_key_exists('next_token', $data) ? $data['next_token'] : false;
        parent::__construct($command,$data);
    }


    /**
     * Send request to get the next page of results
     */
    protected function sendRequest()
    {
        // Throttle requests by waiting 1 second
        sleep(1);

      if($this->resources === null){
          $response      = $this->command->execute();
          $this->nextToken = array_key_exists('next_token', $this->data) ? $this->data['next_token'] : false;
          return $response->get('resources');
      }
      else if($this->getNextToken()!=false) {

          $command      = $this->command;
          $client       = $command->getClient();
          $next_command = $client->getCommand($this->data['next_command']);
          $next_command->setNextToken($this->getNextToken());
          $this->command = $next_command;
          $response      = $this->command->execute();

          return $this->processResult($response);
      }
        return null;
    }



    /**138689654124
     * Process results, add
     *
     * @param SimpleXMLElement $result
     */
    protected function processResult(\SimpleXMLElement $result)
    {
        // @codeCoverageIgnoreStart
        if ($result->{$this->data['result_node']}) {
            $records = $result->{$this->data['result_node']}->toArray();
        } else {
            $records = $result->xpath($this->data['record_path']);
        }
        // @codeCoverageIgnoreEnd

        $this->retrievedCount += count($this->resources);
        $this->currentIndex = 0;

        // @codeCoverageIgnoreStart
        if ((string) $result->HasNext == 'true') {
            $this->nextToken = (string) $result->NextToken;
        } else {
            $this->nextToken = null;
        }
        // @codeCoverageIgnoreEnd
        return $records;
    }

}