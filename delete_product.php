<?php
require_once '../config/database.php';
require_once '../models/Product.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = new Database();
    $database = $db->getConnection();
    $product = new Product($database);
    
    if ($product->delete($_POST['id'])) {
        $response['success'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response); 