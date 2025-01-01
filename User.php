<?php
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class User {
    private $db;
    private $collection;
    
    public function __construct($database) {
        $this->db = $database;
        $this->collection = $this->db->users;
    }
    
    public function authenticate($email, $password) {
        $user = $this->collection->findOne(['email' => $email]);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
    
    public function create($data) {
        if ($this->emailExists($data['email'])) {
            throw new Exception('Email sudah terdaftar');
        }
        
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = new \MongoDB\BSON\UTCDateTime();
        $data['role'] = 'user';
        return $this->collection->insertOne($data);
    }
    
    public function emailExists($email) {
        return $this->collection->countDocuments(['email' => $email]) > 0;
    }
} 