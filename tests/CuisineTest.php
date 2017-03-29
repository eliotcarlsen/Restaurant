<?php
  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */
   $server = 'mysql:host=localhost:8889;dbname=restaurants';
   $username = 'root';
   $password = 'root';
   $DB = new PDO($server, $username, $password);

   require_once "src/Cuisine.php";
   require_once "src/Restaurant.php";

   class CuisineTest extends PHPUnit_Framework_TestCase {

     protected function tearDown()
     {
        Restaurant::deleteAll();
        Cuisine::deleteAll();
     }

     function test_save()
     {
       $test_input = new Cuisine("American");
       $result=$test_input->save();
       $this->assertTrue($result, "Task not successfully saved to database");
     }

     function test_getAll()
     {
        $test_cuisine = new Cuisine("Italian");
        $executed = $test_cuisine->save();
        $test_cuisine2 = new Cuisine("Korean");
        $executed2 = $test_cuisine2->save();

        $result = Cuisine::getAll();
        $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
     }

     function test_deleteAll()
     {
        $test_cuisine = new Cuisine("Italian");
        $executed = $test_cuisine->save();
        $test_cuisine2 = new Cuisine("Korean");
        $executed2 = $test_cuisine2->save();

        $result2 = Cuisine::deleteAll();
        $result = Cuisine::getAll();
        $this->assertEquals([], $result);
     }
   }

?>
