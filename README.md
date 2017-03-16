SimpleMongoDB, simple handler to MongoDB PHP5/7

# Install composer
"require": {
  "macrotux/simplemongodb": "dev-master",
 }

# Install required 
* Mongodb driver, is required for mongodb/mongodb
* sudo pecl install mongodb
* Edit php.ini add line "extension=mongodb.so"

# Use examples

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
 
# License

The MIT License (MIT)   
Copyright (c) 2016   
Jairo Caro-Accino Viciana   
kidandcat@gmail.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

