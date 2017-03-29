<?php
    class Restaurant
    {
        private $name;
        private $location;
        private $cuisine_id;
        private $id;

        function __construct($name, $location, $cuisine_id = null, $id = null)
        {
            $this->name = $name;
            $this->location = $location;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;

        }

        function getId()
        {
            return $this->id;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function getName()
        {
            return $this->name;
        }
        function setLocation($new_location)
        {
            $this->location = $new_location;
        }
        function getLocation()
        {
            return $this->location;
        }
        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO restaurantz (name, location, cuisine_id) VALUES ('{$this->getName()}','{$this->getLocation()}','{$this->getCuisineId()}');");
            if($executed){
              $this->id = $GLOBALS['DB']->lastInsertId();
              return true;
            } else {
              return false;
            }
        }
        static function getAll()
        {
            $returned = $GLOBALS['DB']->query("SELECT * FROM restaurantz;");
            $restaurants = array();
            foreach ($returned as $restaurant)
                {
                    $name = $restaurant['name'];
                    $location = $restaurant['location'];
                    $cuisine_id = $restaurant['cuisine_id'];
                    $id = $restaurant['id'];
                    $new_restaurant = new Restaurant($name, $location, $cuisine_id, $id);
                    array_push($restaurants, $new_restaurant);
                }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurantz;");
        }

        static function find($id)
        {
          $found_restaurant = null;
          $returned = $GLOBALS['DB']->prepare("SELECT * FROM restaurantz WHERE id = :id;");
          $returned->bindParam(':id', $id, PDO::PARAM_STR);
          $returned->execute();
          $result = $returned->fetch(PDO::FETCH_ASSOC);
          if ($result['id'] == $id){
            $found_restaurant = new Restaurant($result['name'],$result['location'], $result['cuisine_id']);
          }
          return $found_restaurant;
        }

        static function getRestaurants($cuisine)
        {
          $found_restaurant = array();
          $returned = $GLOBALS['DB']->prepare("SELECT * FROM restaurantz WHERE cuisine_id = :cuisine_id;");
          $returned->bindParam(':cuisine_id', $cuisine, PDO::PARAM_STR);
          $returned->execute();
          $result = $returned->fetchAll(PDO::FETCH_ASSOC);
          foreach($result as $restaurant)
          {
              $restaurant = new Restaurant($restaurant['name'], $restaurant['location'], $restaurant['cuisine_id'], $restaurant['id']);
              array_push($found_restaurant, $restaurant);
          }
          return $found_restaurant;
        }
    }





?>
