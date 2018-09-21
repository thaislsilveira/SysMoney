<?php

namespace app\model;

final class CategoryModel extends \core\mvc\Model{


    private $name;


    public function __construct($id = null, $name = null)
    {
        parent :: __construct($id);
        $this->name = $name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this ->name;
    
    }

    public function show(){

    }

}