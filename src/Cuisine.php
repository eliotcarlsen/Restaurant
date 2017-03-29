<?php
 class Cuisine
 {
    private $id;
    private $type;

        function __construct($id=null, $type)
        {
          $this->id = $id;
          $this->type = $type;
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



 }
?>
