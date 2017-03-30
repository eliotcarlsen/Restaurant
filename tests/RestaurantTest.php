<?php
 /**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
  require_once "src/Restaurant.php";
  require_once "src/Cuisine.php";

  $server = 'mysql:host=localhost:8889;dbname=restaurants';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);



  class RestaurantTest extends PHPUnit_Framework_TestCase
  {
    protected function tearDown()
    {
        Restaurant::deleteAll();
        Cuisine::deleteAll();
    }
    function test_getId()
    {
        $name = "American";
        $test_cuisine = new Cuisine($name);
        $test_cuisine->save();

        $restaurant = "McDonalds";
        $cuisine_id = $test_cuisine->getId();
        $test_restaurant = new Restaurant($restaurant, "123", $cuisine_id);
        $test_restaurant->save();

        $result = $test_restaurant->getID();
        $this->assertEquals(true, is_numeric($result));
    }

    function test_getCuisineId()
    {
      $name = "American";
      $test_cuisine = new Cuisine($name);
      $test_cuisine->save();

      $restaurant = "McDonalds";
      $cuisine_id = $test_cuisine->getId();
      $test_restaurant = new Restaurant($restaurant, "123", $cuisine_id);
      $test_restaurant->save();

      $result = $test_restaurant->getCuisineId();

      $this->assertEquals($cuisine_id, $result);
    }

    function test_save(){
      $cuisine_type = "American";
      $test_cuisine = new Cuisine($cuisine_type);
      $test_cuisine->save();

      $name = "jimmies";
      $location = "17304 main ave";
      $cuisine_id = $test_cuisine->getId();

      $test_restaurant = new Restaurant($name, $location, $cuisine_id);

      $executed = $test_restaurant->save();

      $this->assertTrue($executed, "Task not successfully saved to database");
    }
    function test_getAll()
    {
        $test_cuisine = new Cuisine("mexican");
        $test_cuisine->save();
        $cuisine_id = $test_cuisine->getId();

        $name = "mcdonalds";
        $location = "123 main st";
        $test_restaurant = new Restaurant($name, $location, $cuisine_id);
        $test_restaurant->save();

        $name2 = "wendys";
        $location2 = "789 walnut";
        $test_restaurant2 = new Restaurant($name2, $location2, $cuisine_id);
        $test_restaurant2->save();

        $result = Restaurant::getAll();
        $this->assertEquals([$test_restaurant, $test_restaurant2], $result);

    }
    function test_deleteAll()
    {
        $test_cuisine = new Cuisine("mexican");
        $test_cuisine->save();
        $cuisine_id = $test_cuisine->getId();

        $name = "mcdonalds";
        $location = "123 main st";

        $test_restaurant = new Restaurant($name, $location, $cuisine_id);
        $test_restaurant->save();

        $name2 = "wendys";
        $location2 = "789 walnut";
        $test_restaurant2 = new Restaurant($name2, $location2, $cuisine_id);
        $test_restaurant2->save();


        $result = Restaurant::deleteAll();
        $result2 = Restaurant::getAll();
        $this->assertEquals([], $result2);
    }

    function test_findRestaurantByCuisine()
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
        $results = Restaurant::getRestaurants($cuisine_id2);

        $this->assertEquals($restaurant2, $results);
    }

  }

 ?>
