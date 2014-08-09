<?php
	include_once 'User.php';

	class Seller extends User{

	    private $ID_S;
	    private $seller_id;
		
	    public function __construct(){
		    parent::__construct();
        	    $this->setRole(User::Seller);
	    }

	    public function setIDS($ID_S){
		$this->ID_S=$ID_S;
	    }
	    public function getIDS(){
		return $this->ID_S;
	    }
	    public function setSellerId($seller_id){
		$this->seller_id=$seller_id;
	    }
	    public function getSellerId(){
		return $this->seller_id;
	    }

	}
?>
