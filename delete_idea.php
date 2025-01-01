<?php
require_once '../config/database.php';
require_once '../models/Idea.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = new Database();
    $database = $db->getConnection();
    $idea = new Idea($database);
    
    if ($idea->delete($_POST['id'])) {
        $response['success'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response); 