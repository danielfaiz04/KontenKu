<?php
require_once 'config/database.php';
require_once 'models/User.php';

$db = new Database();
$database = $db->getConnection();

// Buat collections dengan validasi
$database->createCollection('users', [
    'validator' => [
        '$jsonSchema' => [
            'bsonType' => 'object',
            'required' => ['name', 'email', 'password', 'role'],
            'properties' => [
                'name' => ['bsonType' => 'string'],
                'email' => ['bsonType' => 'string'],
                'password' => ['bsonType' => 'string'],
                'role' => ['enum' => ['admin', 'user']],
                'created_at' => ['bsonType' => 'date']
            ]
        ]
    ]
]);

$database->createCollection('ideas', [
    'validator' => [
        '$jsonSchema' => [
            'bsonType' => 'object',
            'required' => ['title', 'description', 'category', 'status', 'jenis', 'user_id'],
            'properties' => [
                'title' => ['bsonType' => 'string'],
                'description' => ['bsonType' => 'string'],
                'category' => ['bsonType' => 'string'],
                'status' => ['enum' => ['draft', 'aktif', 'selesai', 'arsip']],
                'jenis' => ['enum' => ['edukasi', 'promosi', 'hiburan', 'tutorial']],
                'user_id' => ['bsonType' => 'objectId'],
                'created_at' => ['bsonType' => 'date'],
                'tags' => ['bsonType' => 'array'],
                'produk' => ['bsonType' => 'string'],
                'views' => ['bsonType' => 'int'],
                'likes' => ['bsonType' => 'int']
            ]
        ]
    ]
]);

$database->createCollection('products', [
    'validator' => [
        '$jsonSchema' => [
            'bsonType' => 'object',
            'required' => ['name', 'user_id'],
            'properties' => [
                'name' => ['bsonType' => 'string'],
                'description' => ['bsonType' => 'string'],
                'price' => ['bsonType' => 'double'],
                'user_id' => ['bsonType' => 'objectId'],
                'created_at' => ['bsonType' => 'date']
            ]
        ]
    ]
]);

// Buat indeks
$database->users->createIndex(['email' => 1], ['unique' => true]);
$database->ideas->createIndex(['title' => 'text', 'tags' => 'text']);
$database->categories->createIndex(['name' => 1], ['unique' => true]);
$database->products->createIndex(['name' => 1]);

// Buat user admin pertama
$user = new User($database);
$adminData = [
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => 'admin123',
    'role' => 'admin'
];

try {
    $user->create($adminData);
    echo "Setup berhasil!\n";
    echo "Collections dan indeks telah dibuat\n";
    echo "User admin telah dibuat:\n";
    echo "Email: admin@example.com\n";
    echo "Password: admin123\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
