<?php

namespace Sync\Support;

use PDO;

class Database
{
    private static $instance;

    protected $driver;
    protected $host;
    protected $username;
    protected $password;
    protected $database;
    protected $pdoInstance;

    private function __construct($driver, $host, $username, $password, $database)
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new static(
                getenv('DB_DRIVER'),
                getenv('DB_HOST'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD'),
                getenv('DB_DATABASE')
            );
        }

        return self::$instance;
    }

    protected function connect()
    {
        $dsn = "{$this->driver}:dbname={$this->database};host={$this->host}";

        if ($this->driver == 'sqlite') {
            $dsn = "{$this->driver}:{$this->host}";
        }

        $this->pdoInstance = new PDO(
            $dsn,
            $this->username,
            $this->password
        );
    }

    public function query($query, array $params = [])
    {
        $statement = $this->pdoInstance->prepare($query);
        $statement->execute($params);

        return $statement;
    }
}
