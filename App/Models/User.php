<?php

namespace App\Models;

class User{
    private $name;
    
    public function SetName($name){
       $this->name = $name; 
    }

    public function getName(){
        return $this->name;
    }
}

?>