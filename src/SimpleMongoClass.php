<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SimpleMongoDB;
/**
 * Description of SimpleMongoDb
 *
 * @author Javier Feria <info@javierferia.com>
 */
class SimpleMongoClass {
    
    const PROTOCOL = 'mongodb://';
    const PORT = '27017';
    
    private $isConnect = true;    
    private $MongoDBClient;
    
    /**
     * Current Collection
     * @var \MongoDB\Collection 
     */
    private $Collection;
    
    /**
     * Construct
     * @param string $server    Server hostname
     * @param string $port      Port
     * @throws Exceptions\ConnectionFailException
     */
    function __construct ($server = 'localhost', $port = self::PORT) {
               
        try{
            
            /* @var $MongoDBClient \MongoDB\Client */
            $MongoDBClient = new \MongoDB\Client(self::PROTOCOL.$server.":".$port,[],[
                'typeMap' => [
                    'root' => 'array', 
                    'document' => 'array', 
                    'array' => 'array'
                ]
            ]);
            $MongoDBClient->listDatabases(); //info
            $this->MongoDBClient = $MongoDBClient;
        } catch (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            $this->isConnect = false;
            throw new Exceptions\ConnectionFailException('Error no connect to data base: '.$e->getMessage());
        } catch (\Exception $ex) {            
            $this->isConnect = false;
            throw new Exceptions\ConnectionFailException('Error no connect to data base: '.$ex->getMessage());
        }
        
    }   
    
    /**
     * Return MongoClient
     * @return \MongoDB\Client
     */
    private function getConnect(){
        return  $this->MongoDBClient;
    }
    
    /**
     * Return status connection
     * @return boolean
     */
    public function isConnect(){
        return $this->isConnect;
    }
    
    /**
     * Return MongoCollection
     * @return \MongoDB\Collection
     * @throws Exceptions\NoCollectionExecption
     */
    public function getCollection() {        
        if ( !$this->Collection ) {
            throw new \SimpleMongoDB\Exceptions\NoCollectionExecption('No Collection found, type setCollection()');
        } // if ( !$this->Collection )
        return $this->Collection;
    }
    
    /**
     * Set MongoCollection
     * @param string $name
     * @param string $database
     * @return SimpleMongoClass
     */
    public function setCollection($name, $database = 'local'){        
        /* @var $Collection \MongoDB\Collection */
        $this->Collection = $this->getConnect()->selectCollection($database, $name);
        return $this;
    }
    
    /**
     * Update documents by String Id
     * @param array $data
     * @return integer  Count update documents
     * @throws Exceptions\NoCollectionExecption
     */
    public function insert(array $data){
        unset($data['_id']); // Cleaning _id no allowe
        /* var $InsertOneResult \MongoDB\InsertOneResult */
        $InsertOneResult = $this->getCollection()->insertOne($data);
        return $InsertOneResult->getInsertedId();
    }
    
    /**
     * Update documents by String Id
     * @param string $mongoIdStr
     * @param array $data
     * @return integer  Count update documents
     * @throws Exceptions\NoCollectionExecption
     */
    public function updateByMongoId ($mongoIdStr, array $data){        
        $MongoId = new \MongoDB\BSON\ObjectID($mongoIdStr);
        /* var $UpdateResult \MongoDB\UpdateResult */
        $UpdateResult = $this->getCollection()->updateOne(['_id'=>$MongoId], ['$set'=>$data]);
        return $UpdateResult->getModifiedCount();
    }
    
    /**
     * Update
     * @param array $filter
     * @param array $data
     * @return integer  Count update documents
     * @throws Exceptions\NoCollectionExecption
     */
    public function update (array $filter, array $data){
        unset($data['_id']); // Cleaning _id no allowe
        $UpdateResult = $this->getCollection()->updateOne($filter, ['$set'=>$data]);
        return $UpdateResult->getModifiedCount();
    }
    
    /**
     * Update documents
     * @param \MongoDB\BSON\ObjectID $MongoId
     * @param array $data
     * @return integer  Count update documents
     * @throws Exceptions\NoCollectionExecption
     */
    public function updateByObjectID(\MongoDB\BSON\ObjectID $MongoId, array $data){       
        /* var $UpdateResult \MongoDB\UpdateResult */
        $UpdateResult = $this->getCollection()->updateOne(['_id'=>$MongoId], ['$set'=>$data]);        
        return $UpdateResult->getModifiedCount();
    }
    
    /**
     * Find
     * @param string $mongoIdStr
     * @return array
     * @throws Exceptions\NoCollectionExecption
     */
    public function findByMongoId($mongoIdStr){
        $MongoId = new \MongoDB\BSON\ObjectID($mongoIdStr);
        /* var $InsertOneResult \MongoDB\UpdateResult */
        return $this->getCollection()->findOne(['_id'=>$MongoId]);
    }
    
    /**
     * Find 
     * @param string $collectionName
     * @param \MongoDB\BSON\ObjectID $MongoId
     * @return array
     * @throws Exceptions\NoCollectionExecption
     */
    public function findByObjectID(\MongoDB\BSON\ObjectID $MongoId){        
        return $this->getCollection()->findOne(['_id'=>$MongoId]);        
    }
    
    public function find(array $filter){
        return $this->getCollection()->findOne($filter);
    }
    
    public function findBy(array $filter, array $fields = []){
        return $this->getCollection()->find($filter, $fields);
    }
    
    /**
     * Delete
     * @param array $filter
     * @return integer  count remove
     * @throws Exceptions\NoCollectionExecption
     */
    public function remove(array $filter){
        return $this->getCollection()->deleteOne($filter)->getDeletedCount();        
    }
    
    /**
     * Delete by string _id
     * @param string $mongoIdStr
     * @return integer  count remove
     */
    public function removeByMongoId($mongoIdStr){
        $MongoId = new \MongoDB\BSON\ObjectID($mongoIdStr);
        return $this->getCollection()->deleteOne($MongoId)->getDeletedCount();
    }
    
}
