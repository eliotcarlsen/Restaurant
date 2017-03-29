<?php
 /**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
  $server = 'mysql:host=localhost:8889;dbname=restaurants';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  require_once "src/Restaurant.php";

  class RestaurantTest extends PHPUnit_Framework_TestCase {
    protected function tearDown()
    {
        Restaurant::deleteAll();
    }

    function test_save(){
      $test_input = new Restaurant("jimmies", "17304 main ave.");

      $result=$test_input->save();
      $this->assertTrue($result, "Task not successfully saved to database");
    }
    function test_getAll()
    {
        $name = "mcdonalds";
        $location = "123 main st";
        $test_restaurant = new Restaurant($name, $location);
        $test_restaurant->save();

        $name2 = "wendys";
        $location2 = "789 walnut";
        $test_restaurant2 = new Restaurant($name2, $location2);
        $test_restaurant2->save();

        $result = Restaurant::getAll();
        $this->assertEquals([$test_restaurant, $test_restaurant2], $result);

    }
    function test_deleteAll()
    {
        $name = "mcdonalds";
        $location = "123 main st";
        $test_restaurant = new Restaurant($name, $location);
        $test_restaurant->save();

        $name2 = "wendys";
        $location2 = "789 walnut";
        $test_restaurant2 = new Restaurant($name2, $location2);
        $test_restaurant2->save();


        $result = Restaurant::deleteAll();
        $result2 = Restaurant::getAll();
        $this->assertEquals([], $result2);
    }
  }

 ?>
