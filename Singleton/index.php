<?php

class ConfigManager
{
    private static ?ConfigManager $instance = null; // Holds the single instance
    private array $config = []; // Stores configuration data

    // Private constructor to prevent external instantiation
    private function __construct()
    {
        // Load configuration from a file or database
        $this->config = [
            'app_name' => 'My Laravel App',
            'version' => '1.0.0',
            'timezone' => 'UTC',
        ];
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserialization of the instance
    private function __wakeup() {}

    // Static method to get the single instance
    public static function getInstance(): ConfigManager
    {
        if (self::$instance === null) {
            self::$instance = new ConfigManager();
        }
        return self::$instance;
    }

    // Method to get configuration values
    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    // Method to set configuration values
    public function set(string $key, $value): void
    {
        $this->config[$key] = $value;
    }
}

// Usage Example
$configManager1 = ConfigManager::getInstance();
echo $configManager1->get('app_name') . PHP_EOL; // Output: My Laravel App

$configManager1->set('app_name', 'Updated Laravel App');

$configManager2 = ConfigManager::getInstance();
echo $configManager2->get('app_name') . PHP_EOL; // Output: Updated Laravel App

// Both $configManager1 and $configManager2 are the same instance
var_dump($configManager1 === $configManager2); // Output: bool(true)
