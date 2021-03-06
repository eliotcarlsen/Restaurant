<?php
 class Cuisine
 {
    private $type;
    private $id;

        function __construct($type, $id=null)
        {
          $this->type = $type;
          $this->id = $id;
        }

        function setType($new_type)
        {
            $this->type = $new_type;
        }
        function getType()
        {
            return $this->type;
        }
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO cuisines (type) VALUES ('{$this->getType()}')");
            if ($executed)
            {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = array();
            foreach ($returned as $cuisine)
                {
                    $id = $cuisine['id'];
                    $type = $cuisine['type'];
                    $new_cuisine = new Cuisine($type, $id);
                    array_push($cuisines, $new_cuisine);
                }
            return $cuisines;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");
        }

        static function find($id)
        {
            $found_cuisine = null;
            $returned = $GLOBALS['DB']->prepare("SELECT * FROM cuisines WHERE id = :id;");
            $returned->bindParam(':id', $id, PDO::PARAM_STR);
            $returned->execute();
            $result = $returned->fetch(PDO::FETCH_ASSOC);
            if($result['id'] == $id ){
              $found_cuisine = new Cuisine($result['type'], $result['id']);
              return $found_cuisine;
            }
        }
 }
?>
