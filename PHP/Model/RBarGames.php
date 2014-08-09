<?php

class RBarGames{

    private $title;
    private $cover;
    private $id;

    public function __construct() {
        
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setTitle($title){
        $this->title = $title;
    }
    
    public function getTitle(){
        return $this->title;
    }
    
    public function setCover($cover){
        $this->cover = $cover;
    }
    
    public function getCover(){
        return $this->cover;
    }
    

}

?>
