<?php

namespace PDO_CONN;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use PDO;
use Config\ProjectConfig;

class Connection
{
    public $connObj;
    function __construct()
    {
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $config = new ProjectConfig();
        $config->enableError();
        $dbcreds = $config->config["db"];
        $dsn = $dbcreds['type'] . ":host=" . $dbcreds['host'] . ";port=". $dbcreds['port'] . ";dbname=" . $dbcreds['dbname'];
        $this->connObj = new PDO($dsn, $dbcreds['username'], $dbcreds['password'], $options);
    }
    public function exeQuery($stmt, $params=NULL)
    {
        if ($params==NULL) return $this->connObj->query($stmt)->fetchAll();
        else {
            $prepared = $this->connObj->prepare($stmt);
            $prepared->execute($params);
            if (preg_match("#select#i", $stmt)) return $prepared->fetchAll();
        }
    }
}
