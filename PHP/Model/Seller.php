<?php
	include_once 'User.php';

	class Seller extends User{
		
		public function __construct(){
			parent::__construct();
        		$this->setRole(User::Seller);
		}

	}
?>
