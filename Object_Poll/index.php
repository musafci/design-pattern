<?php

namespace App\ObjectPool;

class DatabaseConnection
{
    private $connection;

    public function __construct($config)
    {
        // Simulate a database connection
        $this->connection = "Connected to DB with config: " . json_encode($config);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

class DatabaseConnectionPool
{
    private $availableConnections = [];
    private $usedConnections = [];
    private $maxConnections;

    public function __construct($maxConnections = 5)
    {
        $this->maxConnections = $maxConnections;
    }

    public function getConnection($config)
    {
        // Reuse an available connection
        if (count($this->availableConnections) > 0) {
            $connection = array_pop($this->availableConnections);
            $this->usedConnections[] = $connection;
            return $connection;
        }

        // Create a new connection if the pool is not full
        if (count($this->usedConnections) < $this->maxConnections) {
            $connection = new DatabaseConnection($config);
            $this->usedConnections[] = $connection;
            return $connection;
        }

        throw new \Exception("No available connections in the pool.");
    }

    public function releaseConnection($connection)
    {
        $key = array_search($connection, $this->usedConnections, true);
        if ($key !== false) {
            unset($this->usedConnections[$key]);
            $this->availableConnections[] = $connection;
        }
    }
}

// Usage Example
$config = ['host' => 'localhost', 'user' => 'root', 'password' => '', 'database' => 'test'];
$pool = new DatabaseConnectionPool(3);

try {
    // Get a connection from the pool
    $conn1 = $pool->getConnection($config);
    echo $conn1->getConnection() . PHP_EOL;

    $conn2 = $pool->getConnection($config);
    echo $conn2->getConnection() . PHP_EOL;

    // Release a connection back to the pool
    $pool->releaseConnection($conn1);

    // Reuse the released connection
    $conn3 = $pool->getConnection($config);
    echo $conn3->getConnection() . PHP_EOL;

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
