<?php

namespace Sync;

use Lscms\IoC\IoC;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Command\Command;
use Sync\Support\Database;

class App
{
    /**
     * @var Singleton
     */
    private static $instance = null;

    /**
     * @var IoC
     */
    private $container;

    /**
     * @var Console
     */
    private $console;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Database
     */
    private $database;

    public function __construct(IoC $container, Console $console, Database $database)
    {
        $this->container = $container;
        $this->console = $console;
        $this->database = $database;
    }

    /**
     * Get the database instance
     *
     * @return Database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Add a new command to the console
     *
     * @param Command $command
     */
    public function addCommand($command)
    {
        $command = $this->resolve($command);

        $this->console->add($command);
    }

    /**
     * Set the logger implementation
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get the logger
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if (is_null($this->logger)) {
            $logger = new \Monolog\Logger('debug');
            $logger->pushHandler(
                new StreamHandler(getenv('APP_LOGFILE'), Logger::DEBUG)
            );

            $this->setLogger($logger);
        }

        return $this->logger;
    }

    /**
     * Get the log level
     *
     * @return int
     */
    public function getLogLevel()
    {
        if (getenv('DEBUG')) {
            return Logger::DEBUG;
        }

        return Logger::ERROR;
    }

    /**
     * Bind to an interface to its implementation
     *
     * @param $interface
     * @param $implementation
     *
     * @return $this
     */
    public function bind($interface, $implementation)
    {
        $this->container->bind($interface, $implementation);

        return $this;
    }

    /**
     * Resolve out of the IoC container
     *
     * @param $class
     *
     * @return mixed
     */
    public function resolve($class)
    {
        return $this->container->resolve($class);
    }

    /**
     * Init the application
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->console->run();
    }

    /**
     * Retrieve the application instance
     *
     * @param IoC $container
     * @param Console $console
     *
     * @return Singleton
     * @throws \Exception
     */
    public static function start(IoC $container, Console $console, Database $database)
    {
        static::$instance = new static($container, $console, $database);

        return static::getInstance();
    }

    /**
     * Retrieve the instance
     *
     * @return Singleton
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            /**
             * @todo create new exception class
             */
            throw new \Exception('Application not started.');
        }

        return static::$instance;
    }
}
