<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

class Database {
    private $client;
    private $database;
    
    public function __construct() {
        try {
            // Gunakan URI connection string yang lebih lengkap
            $uri = "mongodb://127.0.0.1:27017";
            $options = [
                'serverSelectionTimeoutMS' => 5000, // 5 detik timeout
                'connectTimeoutMS' => 10000, // 10 detik connection timeout
                'retryWrites' => true
            ];
            
            $this->client = new Client($uri, $options);
            
            // Test koneksi
            $this->client->listDatabases();
            
            $this->database = $this->client->kontenku;
            
        } catch (Exception $e) {
            die("Error koneksi database: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->database;
    }
} 