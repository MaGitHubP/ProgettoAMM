<?php
	include_once 'User.php';

	class Buyer extends User{

	    private $ID_B;
	    private $buyer_id;
	    private $credit_card;
	    private $money;
	    private $code_card;
		
	    public function __construct(){
	    parent::__construct();
            $this->setRole(User::Buyer);
	    }

	    public function setIDB($ID_B){
		$this->ID_B=$ID_B;
	    }
	    public function getIDB(){
		return $this->ID_B;
	    }
	    public function setBuyerId($buyer_id){
		$this->buyer_id=$buyer_id;
	    }
	    public function getBuyerId(){
		return $this->buyer_id;
	    }
	    public function setCreditCard($credit_card){
		$this->credit_card=$credit_card;
	    }
	    public function getCreditCard(){
		return $this->credit_card;
	    }
	    public function setMoney($money){
		$this->money=$money;
	    }
	    public function getMoney(){
		return $this->money;
	    }
	    public function setCodeCard($code_card){
		$this->code_card=$code_card;
	    }
	    public function getCodeCard(){
		return $this->code_card;
	    }

	}
?>
