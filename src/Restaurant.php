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
            $executed = $GLOBALS['DB']->exec("INSERT INTO restaurantz (name, location) VALUES ('{$this->getName()}','{$this->getLocation()}');");
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
                    $id = $restaurant['id'];
                    $new_restaurant = new Restaurant($name, $location, null, $id);
                    array_push($restaurants, $new_restaurant);
                }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurantz;");
        }

        function find($id)
        {
          $returned = $GLOBALS['DB']->prepare("SELECT * FROM restaurantz WHERE id = :id;");
          $returned->bindParam(':id', $id, PDO::PARAM_STR);
          $returned->execute();
          $result =$returned->fetch(PDO::FETCH_ASSOC);
          if ($result['id'] ==$id){
            $found_restaurant = new Restaurant($result['name'],$result['location'], $result['cuisine_id']);
          }
          return $found_restaurant;
        }


    }





?>
