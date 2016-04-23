<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Controller;
/**
 * Description of SimpleMongoDb
 *
 * @author macro
 */
class SimpleMongoDb {
    
    private $host = 'localhost';
    private $port = '27017';
    
    private $isConnect = true;
    
    private $MongoDBClient;
    
    /**
     * Construct
     * @param string $server    Server hostname
     * @param string $port      Port
     */
    function __construct (string $server = 'localhost', string $port = '27017') {
               
        try{
            
            /* @var $MongoDBClient \MongoDB\Client */
            $MongoDBClient = new \MongoDB\Client("mongodb://".$this->host.":".$this->port,[],[
                'typeMap' => [
                    'root' => 'array', 
                    'document' => 'array', 
                    'array' => 'array'
                ]
            ]);
            /* var $info \MongoDB\Model\DatabaseInfoLegacyIterator */
            $info = $MongoDBClient->listDatabases();
            $this->MongoDBClient = $MongoDBClient;
        } catch (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            $this->isConnect = false;
            throw new \Exception('Error no connect to data base.');
        } catch (\Exception $ex) {            
            $this->isConnect = false;
            throw new \Exception('Error no connect to data base.');
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
     * Return MongoColection
     * @param string $name
     * @param string $database
     * @return \MongoDB\Collection
     */
    public function getColection(string $name, string $database = 'local') {
        /* @var $Colection \MongoDB\Collection */
        $Colection = $this->getConnect()->selectCollection($database, $name);
        return $Colection;
    }
    
    public function insert(string $colectionName, array $data){
        /* var $InsertOneResult \MongoDB\InsertOneResult */
        $InsertOneResult = $this->getColection($colectionName)->insertOne($data);
        return $InsertOneResult->getInsertedId();
    }
    
    /**
     * Update documents by String Id
     * @param string $colectionName
     * @param string $mongoIdStr
     * @param array $data
     * @return integer  Count update documents
     */
    public function updateByMongoId(string $colectionName, string $mongoIdStr, array $data){        
        $MongoId = new \MongoDB\BSON\ObjectID($mongoIdStr);
        /* var $InsertOneResult \MongoDB\UpdateResult */
        $UpdateResult = $this->getColection($colectionName)->updateOne(['_id'=>$MongoId], ['$set'=>$data]);        
        return $UpdateResult->getModifiedCount();
    }
    
    /**
     * Update documents
     * @param string $colectionName
     * @param \MongoDB\BSON\ObjectID $MongoId
     * @param array $data
     * @return integer  Count update documents
     */
    public function update(string $colectionName, \MongoDB\BSON\ObjectID $MongoId, array $data){       
        /* var $InsertOneResult \MongoDB\UpdateResult */
        $UpdateResult = $this->getColection($colectionName)->updateOne(['_id'=>$MongoId], ['$set'=>$data]);        
        return $UpdateResult->getModifiedCount();
    }
    
    /**
     * Find
     * @param string $colectionName
     * @param string $mongoIdStr
     * @return array
     */
    public function findByMongoId(string $colectionName, string $mongoIdStr){
        $MongoId = new \MongoDB\BSON\ObjectID($mongoIdStr);
        /* var $InsertOneResult \MongoDB\UpdateResult */
        return $this->getColection($colectionName)->findOne(['_id'=>$MongoId]);
    }
    
    /**
     * Find 
     * @param string $colectionName
     * @param \MongoDB\BSON\ObjectID $MongoId
     * @return array
     */
    public function find(string $colectionName, \MongoDB\BSON\ObjectID $MongoId){        
        return $this->getColection($colectionName)->findOne(['_id'=>$MongoId]);        
    }
    
}