<?php
	include_once 'User.php';

	class Buyer extends User{
		
		public function __construct(){
			parent::__construct();
        		$this->setRole(User::Buyer);
		}

	}
?>
