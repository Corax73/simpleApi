<?php

namespace Api\Classes\Controllers;

use Api\Classes\Models\Report;

class ReportsController extends AbstractController
{
    public $apiName = 'reports';

    /**
     * Returns all entries.
     * @return string
     */
    public function index()
    {
        $report = new Report();
        $reports = $report->index();
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
            $reports = $report->show($id);
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
            $resp = $report->save($payment, $check_id);
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
        if (isset($this->requestParams['payment'])) {
            $newData['payment'] = $this->requestParams['payment'];
        }
        if (isset($this->requestParams['check_id'])) {
            $newData['check_id'] = $this->requestParams['check_id'];
        }
        if ($reportId && $newData) {
            $report = new Report();
            if ($report->update($newData, $reportId)) {
                $resp = ['Data updated.'];
                $status = 200;
            }
        }
        return $this->response($resp, $status);
    }

    /**
     * Deletes the record.
     * @return string
     */
    public function delete()
    {
        $resp = ['Report not found.'];
        $status = 404;
        $reportId = array_shift($this->requestUri);
        if ($reportId) {
            $report = new Report();
            if ($report->delete($reportId)) {
                $resp = ['Report deleted.'];
                $status = 200;
            }
        }
        return $this->response($resp, $status);
    }
}
