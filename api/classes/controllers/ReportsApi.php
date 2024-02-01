<?php

namespace Api\Classes\Controllers;

use Api\Classes\Models\Report;

class ReportsApi extends AbstractApi
{
    public $apiName = 'reports';

    /**
     * Returns all entries.
     * @return string
     */
    public function index()
    {
        $report = new Report();
        $reports = $report->getAll();
        $resp = ['Data not found'];
        $status = 404;
        if ($reports) {
            $resp = $reports;
            $status = 200;
        }
        return $this->response($resp, $status);
    }

    /**
     * Returns the first entry.
     * @return string
     */
    public function show()
    {
        $id = array_shift($this->requestUri);

        if ($id) {
            $report = new Report();
            $reports = $report->getOne($id);
            $resp = ['Data not found'];
            $status = 404;
            if ($reports) {
                $resp = $reports;
                $status = 200;
            }
        }
        return $this->response($resp, $status);
    }

    /**
     * Creates a record.
     * @return string
     */
    public function store()
    {
        $payment = $this->requestParams['payment'] ?? '';
        $check_id = $this->requestParams['check_id'] ?? '';
        $resp = false;
        if ($payment && $check_id) {
            $report = new Report();
            $resp = $report->saveReport($payment, $check_id);
        }
        return $this->response($resp ? ['Data saved.'] : ['Error.'], 500);
    }

    /**
     * Updates a record.
     * @return string
     */
    public function update()
    {
        $resp = ['Report not found.'];
        $status = 404;
        $reportId = array_shift($this->requestUri);
        $newData = [];
        if ($this->requestParams['payment']) {
            $newData['payment'] = $this->requestParams['payment'];
        }
        if ($this->requestParams['check_id']) {
            $newData['check_id'] = $this->requestParams['check_id'];
        }
        if ($reportId && $newData) {
            $report = new Report();
            if ($report->updateReport($newData, $reportId)) {
                $resp = ['Data updated.'];
                $status = 200;
            }
        }
        return $this->response($resp, $status);
    }

    public function delete()
    {
        
    }
}
