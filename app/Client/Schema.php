<?php
declare(strict_types=1);

namespace App\Client;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Exception;
use Hyperf\Contract\ConfigInterface;

class Schema
{
    private Connection $conn;
    private string $prefix;

    public function __construct(ConfigInterface $config)
    {
        $cfg = $config->get('databases.default');
        $this->prefix = $cfg['prefix'];
        $this->conn = DriverManager::getConnection([
            'dbname' => $cfg['database'],
            'user' => $cfg['username'],
            'password' => $cfg['password'],
            'host' => $cfg['host'],
            'port' => $cfg['port'],
            'charset' => $cfg['charset'],
            'driver' => 'mysqli',
        ]);
    }

    /**
     * @return AbstractSchemaManager
     * @throws Exception
     */
    public function manager(): AbstractSchemaManager
    {
        return $this->conn->createSchemaManager();
    }

    /**
     * @param string $name
     * @return string
     */
    public function table(string $name): string
    {
        return $this->prefix . $name;
    }
}