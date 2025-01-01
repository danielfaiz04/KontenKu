<?php
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class Idea {
    private $db;
    private $collection;
    
    public function __construct($database) {
        $this->db = $database;
        $this->collection = $this->db->ideas;
    }
    
    public function getAll($filter = []) {
        $pipeline = [
            [
                '$lookup' => [
                    'from' => 'users',
                    'localField' => 'user_id',
                    'foreignField' => '_id',
                    'as' => 'user'
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'categories',
                    'localField' => 'category',
                    'foreignField' => 'name',
                    'as' => 'category_info'
                ]
            ],
            [
                '$unwind' => [
                    'path' => '$user',
                    'preserveNullAndEmptyArrays' => true
                ]
            ],
            [
                '$unwind' => [
                    'path' => '$category_info',
                    'preserveNullAndEmptyArrays' => true
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'title' => 1,
                    'description' => 1,
                    'status' => 1,
                    'jenis' => 1,
                    'category' => 1,
                    'created_at' => 1,
                    'user_name' => ['$ifNull' => ['$user.name', 'Anonymous']],
                    'category_description' => ['$ifNull' => ['$category_info.description', null]]
                ]
            ]
        ];

        // Tambahkan filter jika ada
        if (isset($filter['filter'])) {
            array_unshift($pipeline, ['$match' => $filter['filter']]);
        }

        // Tambahkan sorting
        if (isset($filter['options']['sort'])) {
            $pipeline[] = ['$sort' => $filter['options']['sort']];
        }

        // Tambahkan limit
        if (isset($filter['options']['limit'])) {
            $pipeline[] = ['$limit' => $filter['options']['limit']];
        }

        return $this->collection->aggregate($pipeline);
    }
    
    public function getById($id) {
        $pipeline = [
            [
                '$match' => [
                    '_id' => new ObjectId($id)
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'users',
                    'localField' => 'user_id',
                    'foreignField' => '_id',
                    'as' => 'user'
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'categories',
                    'localField' => 'category',
                    'foreignField' => 'name',
                    'as' => 'category_info'
                ]
            ],
            [
                '$unwind' => [
                    'path' => '$user',
                    'preserveNullAndEmptyArrays' => true
                ]
            ],
            [
                '$unwind' => [
                    'path' => '$category_info',
                    'preserveNullAndEmptyArrays' => true
                ]
            ],
            [
                '$project' => [
                    'title' => 1,
                    'description' => 1,
                    'status' => 1,
                    'jenis' => 1,
                    'media' => 1,
                    'media_type' => 1,
                    'created_at' => 1,
                    'user_name' => '$user.name',
                    'category_description' => '$category_info.description'
                ]
            ]
        ];

        $result = $this->collection->aggregate($pipeline)->toArray();
        return count($result) > 0 ? $result[0] : null;
    }
    
    public function create($data) {
        $data['created_at'] = new UTCDateTime();
        $data['user_id'] = new ObjectId($_SESSION['user_id']);
        $data['jenis'] = $data['jenis'] ?? 'lainnya';
        return $this->collection->insertOne($data);
    }
    
    public function update($id, $data) {
        return $this->collection->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => $data]
        );
    }
    
    public function delete($id) {
        return $this->collection->deleteOne(['_id' => new ObjectId($id)]);
    }

    // Statistik untuk dashboard
    public function getStats() {
        $pipeline = [
            [
                '$facet' => [
                    'byStatus' => [
                        ['$group' => [
                            '_id' => '$status',
                            'count' => ['$sum' => 1]
                        ]]
                    ],
                    'byCategory' => [
                        ['$group' => [
                            '_id' => '$category',
                            'count' => ['$sum' => 1]
                        ]]
                    ],
                    'byJenis' => [
                        ['$group' => [
                            '_id' => '$jenis',
                            'count' => ['$sum' => 1]
                        ]]
                    ]
                    
                ]
            ]
        ];

        $result = $this->collection->aggregate($pipeline)->toArray();
        return count($result) > 0 ? $result[0] : null;
    }
} 