<?php
    include_once basename(__DIR__) . '/../View/ViewDescriptor.php';
    include_once basename(__DIR__) . '/../Model/User.php';
    include_once basename(__DIR__) . '/../Model/UserFactory.php';
    
    /*Questa classe gestisce le pagine "iniziali", cioè quelle in cui 
     *viene richiesto il login.Il metodo handleInput gestisce i vari 
     *input dell'utente.*/
    class InitialController{
        
	const user='user';
	const role='role';
        
        public function __construct() {
            
        }

        /*Questo metodo prende come parametro un input dell'utente e lo gestisce.*/
        public function handleInput(&$request){
            $view=new ViewDescriptor();
            
            $view->setPage($request["page"]);

            if(isset($request["subpage"])){
                switch($request["subpage"]){
                    case "see":
                        $genre="all";
			$console="all";
			$limit_index=$request["limit_index"];
			$this->searchGames($view);
                        break;
		    case "sign_up":
			$view->setSubPage("sign_up");
			$this->showInitialPage($view);
			break;
                    default:
                        $view->setSubPage("home");
                        break;
                }
            }
            
            if(isset($request["cmd"])){
                switch($request["cmd"]){
                    case "login":
                        if(isset($request["username"])){
                            $username=$request["username"];
                        }else{
                            $username='';
                        }
                        if(isset($request["password"])){
                            $password=$request["password"];
                        }else{
                            $password='';
                        }
			/*Qui ritorno una variabile User, in modo che quando viene fatto
			 *il require del Main, le variabili $user siano inizializzate.*/
                        $user=$this->login($view, $username, $password);
                        break;
		    case "sign_up":
			$username=$request["username"];
			$password=$request["password"];
			$name=$request["name"];
			$surname=$request["surname"];
			$role=$request["role"];
			$city=$request["city"];
			$address=$request["address"];
			$email=$request["email"];
			$code=$request["code"];

			if($username=="" || $password=="" || $name=="" || $surname=="" || $city=="" || $address=="" || $email=="" || $code==""){
		    	    $notFull=true;
			}

			if(isset($notFull) && $notFull==true){
		    	    $view->setErrorMessage("Errore:Riempi tutti i campi.\n");
		    	    $user=null;
			}else{
			    $user=$this->SignUp($view, $username, $password, $name, $surname, $role, $city, $address, $email, $code);
			}

			if(!isset($user)){
			    $signupError=true;
			    $view->setSubPage("sign_up");
			    $this->showInitialPage($view);
			}else{
			    $this->showHomeUser($view);
			    //Qui ricarico l'user per rendere subito visibili le modifiche fatte alla carta di credito.
			    $usFac=new UserFactory();
			    $user = $usFac->IdLoadUser($view, $_SESSION[InitialController::user], $_SESSION[InitialController::role]);
			}
			
			break;
                    case "search":
			if(isset($request["research_name"])){
			    $research_name=$request["research_name"];
			    $name_game=$request["namesearch"];
			    //Do un valore alle due variabili genre e console per evitare gli errori di variabili non inizializzate.
			    $genre="set";
                            $console="set";
			}else{
			    $genre=$request["genre"];
                            $console=$request["console"];
			}

			$limit_index=$request["limit_index"];
			$this->searchGames($view);
                        break;

		    case "loginToBuy":
			$id_videogame=$request["id_videogame"];
			$price=$request["price"];
			$genre=$request["genre"];
			$console=$request["console"];
			$notLogged=true;
			$view->setSubPage("see");
			$this->showInitialPage($view);
			break;
		    case "buy":
			$id_videogame=$request["id_videogame"];
			$price=$request["price"];

			if(isset($request["username"])){
                            $username=$request["username"];
                        }else{
                            $username='';
                        }
                        if(isset($request["password"])){
                            $password=$request["password"];
                        }else{
                            $password='';
                        }
			/*Qui ritorno una variabile User, in modo che quando viene fatto
			 *il require del Main, le variabili $user siano inizializzate.*/
                        $user=$this->login($view, $username, $password);

			/*Se c'è qualche problema nel login, riinizializzo le variabili 
			 *$genre e $console in modo da rifare la ricerca dei videogiochi, 
			 *quindi la pagina ritorna a SeeGames del login.*/
			if(!isset($user)){
			    $genre=$request["genre"];
			    $console=$request["console"];
			    $notLogged=true;
			    $wrongLogin=1;
			    $limit_index=0;
			    $this->showInitialPage($view);
			}else if($user->getRole()==User::Seller){
			    $genre=$request["genre"];
			    $console=$request["console"];
			    $notLogged=true;
			    $wrongLogin=2;
			    $limit_index=0;
			    $this->logout($view);
			}else{
			    $genre=$request["genre"];
			    $console=$request["console"];
			    //Variabile usata nel SeeGames di Buyer.
			    $confirm=true;
			}
			
			$view->setSubPage("see");

		        break;
                    default:
                        $this->showInitialPage($view);
                }
            }else{
                $this->showInitialPage($view);
            }
            require basename(__DIR__) . '/../View/Main.php';
        }
        
	/*Questo metodo gestisce il login dell'utente.*/
        public function login($view, $username, $password){
		$usFac=new UserFactory();
		$user=$usFac->loadUser($view, $username, $password);
		if(isset($user)){
			$_SESSION[self::user] = $user->getId();
            		$_SESSION[self::role] = $user->getRole();
			$this->showHomeUser($view);
			return $user;
		}else{
			$view->setErrorMessage("Errore:Username o password errata.");
            		$this->showInitialPage($view);
		}
	}

	/*Questo metodo gestisce il logout.*/
	public function logout($view){
		//Resetto $_SESSION con un array vuoto.
        	$_SESSION = array();
        	//Termino la validita' del cookie di sessione
        	if (session_id() != '' || isset($_COOKIE[session_name()])) {
            	//Imposto il termine di validita' al mese scorso
            	setcookie(session_name(), '', time() - 2592000, '/');
        	}
        	//Distruggo il file di sessione
        	session_destroy();
        	$this->showInitialPage($view);
	}

	/*Questo metodo ritorna true se l'utente è loggato, false altrimenti.*/
	public function isLogged(){
		return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
	}

	/*Questo metodo setta le variabili del ViewDescriptor in modo da mostrare 
	 *la pagina per gli utenti non loggati.*/
	public function showInitialPage($view){
		$view->setTitle("GiochiAMMO.com - Benvenuto");
		$view->setHeader(basename(__DIR__) . '/../View/Login/Header.php');
		$view->setLog(basename(__DIR__) . '/../View/Login/Nav.php');
		$view->setLeftBar(basename(__DIR__) . '/../View/Login/LeftBar.php');
		$view->setContent(basename(__DIR__) . '/../View/Login/Content.php');
		$view->setPage("login");
	}
	
	/*Questo metodo verifica il ruolo dell'utente loggato e chiama il metodo 
	 *showHomeBuyer se è un compratore, oppure showHomeSeller se è un venditore.*/
	public function showHomeUser($view){
		$usFac=new UserFactory();
		$user=$usFac->IdLoadUser($view, $_SESSION[self::user], $_SESSION[self::role]);
		switch($user->getRole()){
			case User::Buyer:
				$this->showHomeBuyer($view);
				break;
			case User::Seller:
				$this->showHomeSeller($view);
				break;
		}
	}
	
	/*Questo metodo setta le variabili del ViewDescriptor in modo da mostrare 
	 *la pagina per gli utenti loggati come compratori.*/
	public function showHomeBuyer($view){
		$view->setTitle("GiochiAMMO.com - Compra videogiochi");
		$view->setHeader(basename(__DIR__) . '/../View/Cliente/Header.php');
		$view->setLog(basename(__DIR__) . '/../View/Cliente/Nav.php');
		$view->setLeftBar(basename(__DIR__) . '/../View/Cliente/LeftBar.php');
		$view->setContent(basename(__DIR__) . '/../View/Cliente/Content.php');
		$view->setPage("buyer");
	}

	/*Questo metodo setta le variabili del ViewDescriptor in modo da mostrare 
	 *la pagina per gli utenti loggati come venditori.*/
	public function showHomeSeller($view){
		$view->setTitle("GiochiAMMO.com - Vendi videogiochi");
		$view->setHeader(basename(__DIR__) . '/../View/Venditore/Header.php');
		$view->setLog(basename(__DIR__) . '/../View/Venditore/Nav.php');
		$view->setLeftBar(basename(__DIR__) . '/../View/Venditore/LeftBar.php');
		$view->setContent(basename(__DIR__) . '/../View/Venditore/Content.php');
		$view->setPage("seller");
	}
        
        public function searchGames($view){
                $view->setSubPage("see");
		$this->showInitialPage($view);
        }

	public function SignUp($view, $username, $password, $name, $surname, $role, $city, $address, $email, $code){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		    $view->setErrorMessage("Errore:Digita un indirizzo email valido.\n");
		    $this->showInitialPage($view);
		    return null;
		}
		if(!filter_var($code, FILTER_VALIDATE_REGEXP, array('options'=>array('regexp'=>'/[0-9]{16}/')))){
		    $view->setErrorMessage("Errore:Il codice della carta deve contenere 16 interi.\n");
		    $this->showInitialPage($view);
		    return null;
		}

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
			$this->showHomeUser($view);
			return null;
	    	}else{
			/*Non c'è nessun errore, quindi prima faccio dei controlli per evitare 
			 *dei doppioni, poi inizio una Transizione.*/
			$query="SELECT * FROM user";
			$result=$mysqli->query($query);

			if($mysqli->errno > 0){
			    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    return null;
			}else{
			    while($temp=$result->fetch_row()){
				$temp_username=$temp[3];
				if($username==$temp_username){
				    $view->setErrorMessage("Errore:L'username $username è già utilizzato da qualcun'altro.Scegline un altro.\n");
		    		    $this->showInitialPage($view);
		    		    return null;
				}
			    }
			}

			$query="SELECT * FROM credit_card";
			$result=$mysqli->query($query);

			if($mysqli->errno > 0){
			    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    return null;
			}else{
			    while($temp=$result->fetch_row()){
				$temp_code=$temp[2];
				if($code==$temp_code){
				    $view->setErrorMessage("Errore:Il codice $code c'è già nel nostro database.\nPer ragioni di sicurezza, il codice selezionato non può essere messo.\n");
		    		    $this->showInitialPage($view);
		    		    return null;
				}
			    }
			}

			$mysqli->autocommit(false);

			if($role==2){
			    $temp_role="Buyer";
			}
			$query="INSERT INTO user (id, name, surname, username, password, role, city, address, email) VALUES (default, \"$name\", \"$surname\", \"$username\", \"$password\", \"$temp_role\", \"$city\", \"$address\", \"$email\")";
			$result=$mysqli->query($query);

			if($mysqli->errno > 0){
			    $mysqli->rollback();
			    $mysqli->autocommit(true);
			    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    return null;
			}

			$query="SELECT user.id FROM user WHERE username=\"$username\"";
			$result=$mysqli->query($query);

			if($mysqli->errno > 0){
			    $mysqli->rollback();
			    $mysqli->autocommit(true);
			    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    return null;
			}else{
			    while($temp=$result->fetch_row()){
				$id=$temp[0];
			    }
			}

			$query="INSERT INTO credit_card (id, money, code) VALUES (default, 100.00, $code)";
			$result=$mysqli->query($query);

			if($mysqli->errno > 0){
			    $mysqli->rollback();
			    $mysqli->autocommit(true);
			    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    return null;
			}

			$query="SELECT credit_card.id FROM credit_card WHERE code=$code";
			$result=$mysqli->query($query);

			if($mysqli->errno > 0){
			    $mysqli->rollback();
			    $mysqli->autocommit(true);
			    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    return null;
			}else{
			    while($temp=$result->fetch_row()){
				$temp_card_id=$temp[0];
			    }
			}

			$query="INSERT INTO buyer (id, id_buyer, credit_card) VALUES (default, $id, $temp_card_id)";
			$result=$mysqli->query($query);

			if($mysqli->errno > 0){
			    $mysqli->rollback();
			    $mysqli->autocommit(true);
			    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    return null;
			}

			$mysqli->commit();
			$mysqli->autocommit(true);
			$mysqli->close();
			$user=$this->login($view, $username, $password);
			return $user;
	    	}
	}
    }
?>
