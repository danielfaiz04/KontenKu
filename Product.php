<?php
use MongoDB\BSON\ObjectId;

class Product {
    private $db;
    private $collection;
    
    public function __construct($database) {
        $this->db = $database;
        $this->collection = $this->db->products;
    }
    
    public function create($data) {
        $data['user_id'] = new ObjectId($_SESSION['user_id']);
        return $this->collection->insertOne($data);
    }
    
    public function getAll() {
        return $this->collection->find();
    }
    
    public function getById($id) {
        return $this->collection->findOne(['_id' => new ObjectId($id)]);
    }
    
    public function delete($id) {
        return $this->collection->deleteOne(['_id' => new ObjectId($id)]);
    }
} 