<?php

namespace Api\Classes\Models;

use PDO;

class Report extends AbstractModel
{
    protected $table = 'reports';
    protected $fillable = [
        'payment',
        'check_id'
    ];


    /**
     * Downloading data of all reports.
     * @return array
     */
    public function index(): array
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * Loading data of one report
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE `id` = :id';
        $params = [
            ':id' => $id
        ];
        $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * Save report data.
     * @param string $payment
     * @param string $check_id
     * @return bool
     */
    public function save(string $payment, string $check_id): bool
    {
        $query = 'INSERT INTO ' . $this->table . ' (payment, check_id, created_at) VALUES (:payment, :check_id, :now)';
        $params = [
            ':payment' => $payment,
            ':check_id' => $check_id,
            ':now' => date('Y-m-d h:i:s', time())
        ];
        $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Updates report data.
     * @param array $newData
     * @param int $id
     * @return bool
     */
    public function update(array $newData, int $id): bool
    {
        $resp = false;
        if ($this->show($id)) {
            $keys = array_keys($newData);
            $check = array_diff($keys, $this->fillable);
            if (!$check) {
                $query = 'UPDATE ' . $this->table . ' SET ';
                $params = [];
                foreach ($keys as $key) {
                    $query .= '`' . $key . '` = :' . $key . ', ';
                    $params[':' . $key] = $newData[$key];
                }
                $query = mb_substr($query, 0, -2);
                $query .= ' WHERE `id` = ' . $id;

                $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
                $resp =  $stmt->execute($params);
            }
        }
        return $resp;
    }

    /**
     * Deletes the report.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $resp = false;
        if ($this->show($id)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE `id` = :id';
            $params = [
                ':id' => $id
            ];
            $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
            $resp = $stmt->execute($params);
        }
        return $resp;
    }
}
