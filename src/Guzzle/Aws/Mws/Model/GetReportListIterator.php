<?php

namespace Guzzle\Aws\Mws\Model;

use Guzzle\Service\Resource\ResourceIterator;

class GetReportListIterator extends ResourceIterator {
  protected function sendRequest() {
    $permitted_options = array(
      'max_count',
      'report_type_list',
      'acknowledged',
      'available_from_date',
      'available_to_date',
      'report_request_id_list'
    );
    if($this->nextToken) {
      $this->command->set('next_token', $this->nextToken);
    }

    foreach($this->data as $k => $param) {
      if(in_array($k, $permitted_options)) {
        $this->command->set($k, $param);
      }
    }

    # Prefer max_count over limit, but use limit if it is supplied.
    if(!in_array('max_count', array_keys($this->data)) &&
       array_key_exists('limit', $this->data)
       && $this->data['limit'] > 0) {
      $this->command->set('max_count', $this->data['limit']);
    }

    $result = $this->command->execute();

    if ((string) $result->HasNext == 'true') {
      $this->nextToken = (string) $result->NextToken;
    } else {
      $this->nextToken = null;
    }

    return $result;
  }

    /**
     * Set the maximum number of results to return
     *
     * @param int $maxCount
     *
     * @return GetReportList
     */
    public function setMaxCount($maxCount)
    {
        return $this->set('max_count', $maxCount);
    }

    /**
     * Set the report type list by which to filter
     *
     * @param array $reportTypes
     *
     * @return GetReport
     */
    public function setReportTypeList(array $reportTypes)
    {
        return $this->set('report_type_list', array(
            'Type' => $reportTypes
        ));
    }

    /**
     * Set whether or not to return acknowledged reports
     *
     * @param bool $acknowledged
     *
     * @return GetReport
     */
    public function setAcknowledged($acknowledged)
    {
        return $this->set('acknowledged', $acknowledged);
    }

    /**
     * Set earliest date to return
     *
     * @param \DateTime $availableFromDate
     *
     * @return GetReport
     */
    public function setAvailableFromDate(\DateTime $availableFromDate)
    {
        return $this->set('available_from_date', $availableFromDate);
    }

    /**
     * Set latest date to return
     *
     * @param \DateTime $availableToDate
     *
     * @return GetReport
     */
    public function setAvailableToDate(\DateTime $availableToDate)
    {
        return $this->set('available_to_date', $availableToDate);
    }

    /**
     * Set report request Id list
     *
     * @param array $reportRequestIdList
     *
     * @return GetReport
     */
    public function setReportRequestIdList(array $reportRequestIdList)
    {
        return $this->set('report_request_id_list', array(
            'Id' => $reportRequestIdList
        ));
    }
}