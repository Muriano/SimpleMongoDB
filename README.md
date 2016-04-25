# SimpleMongoDB
SimpleMongoDB, simple handler to MongoDB PHP5/7


Install mongodb driver, is required for mongodb/mongodb

* sudo pecl install mongodb
* Edit php.ini add line "extension=mongodb.so"

#Use examples

 try {
 
  $SimpleMongoDb = new \SimpleMongoDB\SimpleMongoClass('localhost');
    
  $SimpleMongoDb->setCollection('test', 'local');
  
  // Find
  $SimpleMongoDb->getSimpleMongoDb()->find(['_id' => '123465798']); // return array
  // Insert
  $SimpleMongoDb->getSimpleMongoDb()->insert([])->getInsertedId(); // return Id inserted
  // Update
  $SimpleMongoDb->getSimpleMongoDb()->update(['_id' => '123465798'], [])->getModifiedCount(); // return count Modify
  // Remove
  $SimpleMongoDb->getSimpleMongoDb()->remove(['_id' => '123465798'])->getDeletedCount(); // return count deleted
  
 } catch ( \Exception $e ) {

  error_log('Fail connect whith MongoDB: '.$e->getMessage());
  throw $e;
   
 } // try
