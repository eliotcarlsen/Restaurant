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
  require_once "src/Cuisine.php";

  class RestaurantTest extends PHPUnit_Framework_TestCase {
    protected function tearDown()
    {
        Restaurant::deleteAll();
        Cuisine::deleteAll();
    }

    function test_save(){
      $test_input = new Restaurant("jimmies", "17304 main ave.", "mexican");

      $result=$test_input->save();
      $this->assertTrue($result, "Task not successfully saved to database");
    }
    function test_getAll()
    {
        $name = "mcdonalds";
        $location = "123 main st";
        $cuisine = "mexican";
        $test_restaurant = new Restaurant($name, $location, $cuisine);
        $test_restaurant->save();

        $name2 = "wendys";
        $location2 = "789 walnut";
        $cuisine2 = "mexican";
        $test_restaurant2 = new Restaurant($name2, $location2, $cuisine2);
        $test_restaurant2->save();

        $result = Restaurant::getAll();
        $this->assertEquals([$test_restaurant, $test_restaurant2], $result);

    }
    function test_deleteAll()
    {
        $name = "mcdonalds";
        $location = "123 main st";
        $cuisine = "mexican";
        $test_restaurant = new Restaurant($name, $location, $cuisine);
        $test_restaurant->save();

        $name2 = "wendys";
        $location2 = "789 walnut";
        $cuisine2 = "mexican";
        $test_restaurant2 = new Restaurant($name2, $location2, $cuisine2);
        $test_restaurant2->save();


        $result = Restaurant::deleteAll();
        $result2 = Restaurant::getAll();
        $this->assertEquals([], $result2);
    }
    function test_findCuisineId()
    {
        $test_cuisine = new Cuisine("French");
        $test_cuisine->save();

        $cuisine_id = $test_cuisine->getId();
        $name = "CarlsJr";
        $location = "burger";
        $new_restaurant = new Restaurant($name, $location, $cuisine_id);
        $new_restaurant->save();
        $result = $test_cuisine->getId();
        $this->assertEquals($cuisine_id, $result);
    }

    function test_findRestaurantByCuisine()
    {
        $restaurant1 = new Restaurant("TacoBell", "123", "Mexican");
        $restaurant1->save();
        $restaurant2 = new Restaurant("El Burro", "456", "Mexican");
        $restaurant2->save();
        $restaurant3 = new Restaurant("McDs", "678", "American");
        $restaurant3->save();
        $results = Restaurant::getRestaurants("Mexican");

        $this->assertEquals([$restaurant1, $restaurant2], $results);
    }

    function test_findRestaurantById()
    {
      $restaurant1 = new Restaurant("TacoBell", "123", "Mexican");
      $restaurant1->save();
      $restaurant2 = new Restaurant("El Burro", "456", "Mexican");
      $restaurant2->save();
      $restaurant3 = new Restaurant("McDs", "678", "American");
      $restaurant3->save();
      $results = Restaurant::find($restaurant2);
      var_dump($results);
      $this->assertEquals($restaurant2, $results);
    }

  }

 ?>
