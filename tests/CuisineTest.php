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

     function test_find()
     {
       $cuisine = new Cuisine("american");
       $cuisine->save();
       $cuisine_id = $cuisine->getId();

       $cuisine2 = new Cuisine("french");
       $cuisine2->save();
       $cuisine_id2 = $cuisine2->getId();

       $cuisine3 = new Cuisine("mexican");
       $cuisine3->save();
       $cuisine_id3 = $cuisine3->getId();


       $restaurant1 = new Restaurant("TacoBell", "123", $cuisine_id);
       $restaurant1->save();
       $restaurant2 = new Restaurant("El Burro", "456", $cuisine_id2);
       $restaurant2->save();
       $restaurant3 = new Restaurant("McDs", "678", $cuisine_id3);
       $restaurant3->save();
       $results = Cuisine::find($cuisine_id2);

       $this->assertEquals($cuisine2, $results);

     }
   }

?>
