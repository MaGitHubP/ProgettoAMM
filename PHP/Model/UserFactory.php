<?php
    include_once 'User.php';
    include_once 'Buyer.php';
    include_once 'Seller.php';
    
    class UserFactory{
        
        public function __construct() {
            
        }
        
        public function carica($username, $password){
            if($password!="pisano"){
                return null;
            }else{
                if($username=="compratore"){
                    $user=new Buyer();
                    $user->setUsername("MauroBuy");
                    $user->setName("Mauro");
                    $user->setSurname("Pisano");
		    $user->setId(00002);
                    return $user;
                }else if($username=="venditore"){
                    $user=new Seller();
                    $user->setUsername("MauroSell");
                    $user->setName("Mauro");
                    $user->setSurname("Pisano");
		    $user->setId(00001);
                    return $user;
                }else{
                    return null;
                }
            }
        }

	public function IdLoadUser($id, $role){
		if($id==00001 && $role==User::Seller){
			$user=new Seller();
                    	$user->setUsername("MauroSell");
                    	$user->setName("Mauro");
                    	$user->setSurname("Pisano");
		    	$user->setId(00001);
                    	return $user;
		}else if($id==00002 && $role==User::Buyer){
			$user=new Buyer();
                    	$user->setUsername("MauroBuy");
                    	$user->setName("Mauro");
                    	$user->setSurname("Pisano");
		    	$user->setId(00002);
                    	return $user; 
		}else{
			return null;
		}
	}
    }
?>
