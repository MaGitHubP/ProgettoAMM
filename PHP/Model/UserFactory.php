<?php
    include_once 'User.php';
    include_once 'Buyer.php';
    include_once 'Seller.php';
    include_once basename(__DIR__) . '/../Settings.php';
    
    class UserFactory{
        
        public function __construct() {
            
        }
        
	/*Questo metodo carica un utente usando username e password messi in input nel login.
	 *Username e password sono contenuti nel database giochiammo.sql.*/
        public function loadUser($view, $username, $password){
	    //Creo una variabile mysql.
            $mysqli=new mysqli();
	    $mysqli->connect(Settings::$db_host, 
			     Settings::$db_user, 
			     Settings::$db_password, 
			     Settings::$db_name);
	    if($mysqli->connect_errno != 0){
		$idError=$mysqli->connect_errno;
		$msg=$mysqli->connect_error;
		error_log("Errore connessione $idError!$msg", 0);
		$view->setErrorMessage($msg);
		$mysqli->close();
		$initControl=new InitialController();
		$initControl->showInitialPage($view);
		return null;
	    }else{
		//Nessun Errore!Procedo con query e prepared statement.
		$query="SELECT id, name, surname, username, password, role, city, address, email FROM user WHERE username=? AND password=?";

		$stmt=$mysqli->stmt_init();
		$stmt->prepare($query);
		if(!$stmt){
            	    error_log("Errore inizializzazione statement.");
            	    $mysqli->close();
            	    return null;
        	}
        	if(!$stmt->bind_param('ss', $username, $password)){
            	    error_log("Errore nel binding in input.");
            	    $mysqli->close();
            	    return null;
        	}
		if (!$stmt->execute()) {
            	    error_log("Errore nell'esecuzione dello statement.");
            	    return null;
        	}
		
		$row=array();
		$bind=$stmt->bind_result($row['id'], $row['name'], $row['surname'], $row['username'], $row['password'], $row['role'], $row['city'], $row['address'], $row['email']);
		if (!$bind) {
            	    error_log("Errore nel binding in output.");
            	    return null;
        	}
        	if (!$stmt->fetch()) {
            	    return null;
        	}

		$stmt->close();

		//Qui vedo se l'utente caricato è un venditore o un compratore, e mi adeguo di conseguenza.
		if($row['role']=="Buyer"){
                    $temp_id=$row['id'];
		    $query="SELECT buyer.id, buyer.id_buyer, buyer.credit_card FROM buyer JOIN user ON buyer.id_buyer=user.id WHERE user.id=$temp_id";
		    $result=$mysqli->query($query);
		    if($mysqli->errno > 0){
			error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			return null;
		    }else{
			while($temp=$result->fetch_row()){
			    $row['ID_B']=$temp[0];
			    $row['buyer_id']=$temp[1];
                            $row['credit_card']=$temp[2];
			}
		    }
                    $temp_id=$row['buyer_id'];
                    $query="SELECT money, code FROM credit_card JOIN buyer ON credit_card.id=buyer.credit_card WHERE id_buyer=$temp_id;";
                    $result=$mysqli->query($query);
		    if($mysqli->errno > 0){
			error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			return null;
		    }else{
			while($temp=$result->fetch_row()){
			    $row['money']=$temp[0];
                            $row['code_card']=$temp[1];
			}
			//Qui $buyer conterrà un elemento di tipo User(Buyer più precisamente).
                        $buyer=self::loadBuyer($row);
                        $mysqli->close();
                        return $buyer;
                    }
		}else{
                    $temp_id=$row['id'];
		    $query="SELECT seller.id, seller.id_seller FROM seller JOIN user ON seller.id_seller=user.id WHERE user.id=$temp_id";
		    $result=$mysqli->query($query);
		    if($mysqli->errno > 0){
			error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			return null;
		    }else{
			while($temp=$result->fetch_row()){
			    $row['ID_S']=$temp[0];
			    $row['seller_id']=$temp[1];
			}
		    }
		    //Qui $seller conterrà un elemento di tipo User(Seller più precisamente).
		    $seller=self::loadSeller($row);
                    $mysqli->close();
                    return $seller;
		}	
	    }
	    
        }

	//Questo metodo carica un utente usando il suo id primario nel database.
	public function IdLoadUser($view, $id, $role){
	    //Qui controllo se l'id sia effetivamente un intero.
	    $filter_int=filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
	    if(!isset($filter_int)){
                return null;
            }
	    //Creazione di una variabile mysql, con query e prepared statement.
	    $mysqli=new mysqli();
	    $mysqli->connect(Settings::$db_host, 
			     Settings::$db_user, 
			     Settings::$db_password, 
			     Settings::$db_name);
	    if($mysqli->connect_errno != 0){
		$idError=$mysqli->connect_errno;
		$msg=$mysqli->connect_error;
		error_log("Errore connessione $idError!$msg", 0);
		$view->setErrorMessage($msg);
		$mysqli->close();
		$initControl=new InitialController();
		$initControl->showHomeUser($view);
		return null;
	    }

	    $query="SELECT id, name, surname, username, password, role, city, address, email FROM user WHERE id=?";

	    $stmt=$mysqli->stmt_init();
	    $stmt->prepare($query);
	    if(!$stmt){
            	error_log("Errore inizializzazione statement.");
            	$mysqli->close();
            	return null;
            }
            if(!$stmt->bind_param('i', $filter_int)){
            	error_log("Errore nel binding in input.");
            	$mysqli->close();
            	return null;
            }
	    if (!$stmt->execute()) {
            	error_log("Errore nell'esecuzione dello statement.");
            	return null;
            }
		
	    $row=array();
	    $bind=$stmt->bind_result($row['id'], $row['name'], $row['surname'], $row['username'], $row['password'], $row['role'], $row['city'], $row['address'], $row['email']);
	    if (!$bind) {
            	error_log("Errore nel binding in output.");
            	return null;
            }
            if (!$stmt->fetch()) {
            	return null;
            }

	    $stmt->close();

	    //Qui controllo il ruolo dell'utente caricato.
	    switch($role){
		case User::Buyer:
		    $temp_id=$row['id'];
		    $query="SELECT buyer.id, buyer.id_buyer, buyer.credit_card FROM buyer JOIN user ON buyer.id_buyer=user.id WHERE user.id=$temp_id";
		    $result=$mysqli->query($query);
		    if($mysqli->errno > 0){
			error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			return null;
		    }else{
			while($temp=$result->fetch_row()){
			    $row['ID_B']=$temp[0];
			    $row['buyer_id']=$temp[1];
                            $row['credit_card']=$temp[2];
			}
		    }
                    $temp_id=$row['buyer_id'];
                    $query="SELECT money, code FROM credit_card JOIN buyer ON credit_card.id=buyer.credit_card WHERE id_buyer=$temp_id;";
                    $result=$mysqli->query($query);
		    if($mysqli->errno > 0){
			error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			return null;
		    }else{
			while($temp=$result->fetch_row()){
			    $row['money']=$temp[0];
                            $row['code_card']=$temp[1];
			}
			//Qui $buyer conterrà un elemento di tipo User(Buyer più precisamente).
                        $buyer=self::loadBuyer($row);
                        $mysqli->close();
                        return $buyer;
                    }
		    break;

		case User::Seller:
                    $temp_id=$row['id'];
		    $query="SELECT seller.id, seller.id_seller FROM seller JOIN user ON seller.id_seller=user.id WHERE user.id=$temp_id";
		    $result=$mysqli->query($query);
		    if($mysqli->errno > 0){
			error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			return null;
		    }else{
			while($temp=$result->fetch_row()){
			    $row['ID_S']=$temp[0];
			    $row['seller_id']=$temp[1];
			}
		    }
		    //Qui $seller conterrà un elemento di tipo User(Seller più precisamente).
		    $seller=self::loadSeller($row);
                    $mysqli->close();
                    return $seller;
		    break;

		default:
		    return null;
		    break;

	    }
	}

	public function loadSeller($row){
            $seller=new Seller();
            
            $seller->setId($row['id']);
            $seller->setName($row['name']);
            $seller->setSurname($row['surname']);
            $seller->setUsername($row['username']);
            $seller->setPassword($row['password']);
            $seller->setCity($row['city']);
            $seller->setAddress($row['address']);
	    $seller->setEmail($row['email']);
	    $seller->setIDS($row['ID_S']);
            $seller->setSellerId($row['seller_id']);
            
            return $seller;
        }
        
        public function loadBuyer($row){
            $buyer=new Buyer();
            
            $buyer->setId($row['id']);
            $buyer->setName($row['name']);
            $buyer->setSurname($row['surname']);
            $buyer->setUsername($row['username']);
            $buyer->setPassword($row['password']);
            $buyer->setCity($row['city']);
            $buyer->setAddress($row['address']);
	    $buyer->setEmail($row['email']);
	    $buyer->setIDB($row['ID_B']);
            $buyer->setBuyerId($row['buyer_id']);
            $buyer->setCreditCard($row['credit_card']);
            $buyer->setMoney($row['money']);
            $buyer->setCodeCard($row['code_card']);
            
            return $buyer;
        }
    }
?>
