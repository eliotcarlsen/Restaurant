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

   class CuisineTest extends PHPUnit_Framework_TestCase {
     function test_save()
     {
       $test_input = new Cuisine(null, "American");
       $result=$test_input->save();
       $this->assertTrue($result, "Task not successfully saved to database");
     }

     function test_getAll()
     {
        $test_cuisine = new Cuisine(null, "Italian");
        $executed = $test_cuisine->save();
        $test_cuisine2 = new Cuisine(null, "Korean");
        $executed2 = $test_cuisine2->save();

        $result = Cuisine::getAll();
        $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
     }

     function test_deleteAll()
     {
        $test_cuisine = new Cuisine(null, "Italian");
        $executed = $test_cuisine->save();
        $test_cuisine2 = new Cuisine(null, "Korean");
        $executed2 = $test_cuisine2->save();

        $result2 = Cuisine::deleteAll();
        $result = Cuisine::getAll();
        $this->assertEquals([], $result);
     }
   }

?>
